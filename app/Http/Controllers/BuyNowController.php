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
        $image = $request->input('image');

        $buyNowItem = [
            'name'  => $name,
            'price' => $price,
            'image' => $image,
            'qty'   => 1,
        ];

        session(['buy_now_item' => $buyNowItem]);

        return redirect()->route('checkout');
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

                    // Get order details from session
                    $orderName = session('order_name', 'Unknown Customer');
                    $totalPrice = session('payment_price', 0);
                    $cart = session('cart', []);
                    $buyNowItem = session('buy_now_item');
                    
                    $items = $cart;
                    if ($buyNowItem) { $items[] = $buyNowItem; }

                    $this->SendNotification(
                        $orderName,
                        $totalPrice,
                        $items,
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
    function SendNotification($customerName, $total, $items, $fromAccount = 'Unknown')
    {
        $date  = now()->format('d-m-Y h:i A');

        $text  = "<b>New Order Paid!</b>\n";
        $text .= "<b>Customer:</b> {$customerName}\n";
        $text .= "<b>Items:</b>\n";
        
        foreach($items as $item) {
            $text .= "- {$item['name']} (x{$item['qty']})\n";
        }
        
        $text .= "-----\n";
        $text .= "<b>Total Paid:</b> " . number_format($total, 2) . " KHR\n";
        $text .= "<b>From Account:</b> {$fromAccount}\n";
        $text .= "<b>Date:</b> {$date}";

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
