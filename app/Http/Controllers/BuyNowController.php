<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;

class BuyNowController extends Controller
{
    public function buyNow(Request $request)
    {
        $name  = $request->input('name');
        $price = $request->input('price');

        
        session([
            'payment_name'  => $name,
            'payment_price' => $price,
            'telegram_sent' => false, // prevent duplicates
        ]);

        //  Generate KHQR
        $individualInfo = new IndividualInfo(
            bakongAccountID: 'thet_panhayuth@bkrt',
            merchantName: 'Thet panhayuth',
            merchantCity: 'PHNOM PENH',
            currency: KHQRData::CURRENCY_KHR,
            amount: $price,
        );

        $khqr = BakongKHQR::generateIndividual($individualInfo);

        return view('payment', [
            'qrData' => $khqr->data,
            'name'   => $name,
            'price'  => $price,
        ]);
    }

    public function paymentSuccess()
    {
        return view('payment-success', [
            'name'  => session('payment_name'),
            'price' => session('payment_price'),
        ]);
    }

    public function checkTransactionStatus(Request $request)
    {
        $request->validate([
            'md5' => 'required|string',
        ]);

        $md5   = $request->query('md5');
        $token = env('BAKONG_TOKEN');

        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => "Bearer {$token}",
                    'Content-Type'  => 'application/json',
                ])
                ->post(
                    'https://api-bakong.nbc.gov.kh/v1/check_transaction_by_md5',
                    ['md5' => $md5]
                );

            $result = $response->json();

            /**
             * ✅ PAYMENT SUCCESS
             */
            if (($result['responseCode'] ?? null) === 0 && !empty($result['data'])) {

                // 🔐 PREVENT DUPLICATE TELEGRAM MESSAGE
                if (!session('telegram_sent')) {

                    $bakongData = $result['data'];

                    $this->SendNotification(
                        session('payment_name', 'Unknown product'),
                        session('payment_price', 0),
                        1,
                        $bakongData['fromAccountId'] ?? 'Unknown'
                    );

                    session(['telegram_sent' => true]);
                }

                return response()->json([
                    'paid' => true,
                    'amount' => $result['data']['amount'] ?? null,
                    'md5' => $md5,
                ]);
            }

            
            if (($result['responseCode'] ?? null) === 1) {
                return response()->json([
                    'paid' => false,
                    'failed' => true,
                ]);
            }

        
            return response()->json([
                'paid' => false,
                'pending' => true,
            ]);

        } catch (\Throwable $e) {
            Log::error('BAKONG ERROR', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Verification failed'], 500);
        }
    }

    /**
     * 📩 TELEGRAM NOTIFICATION
     */
    function SendNotification($productName, $price, $qty = 1, $fromAccount = 'Unknown')
    {
        $total = number_format($price * $qty, 2);
        $date  = now()->format('d-m-Y h:i A');

        $text  = "<b>Information</b>\n";
        $text .= "1. {$productName} ({$price}$) x {$qty}\n";
        $text .= "-----\n";
        $text .= "<b>Total:</b> {$total}$\n";
        $text .= "<b>Paid:</b> {$fromAccount}\n";
        $text .= "<b>PaidDate:</b> {$date}";

        return Http::withoutVerifying()->post(
            'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage',
            [
                'chat_id' => env('TELEGRAM_CHAT_ID'),
                'text' => $text,
                'parse_mode' => 'HTML',
            ]
        );
    }   
}
