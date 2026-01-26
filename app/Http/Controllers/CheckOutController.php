<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        
        // Handle selective checkout from cart
        if ($request->has('selected_items')) {
            $selectedIds = $request->input('selected_items');
            $cart = array_intersect_key($cart, array_flip($selectedIds));
            // Clear buy_now_item if we are coming from cart selection
            session()->forget('buy_now_item');
        }

        $buyNowItem = session()->get('buy_now_item');
        
        $items = $cart;
        if ($buyNowItem) {
            $items[] = $buyNowItem;
        }

        $total = collect($items)->sum(fn($i) => $i['price'] * $i['qty']);
        
        return view('checkout', compact('items', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'location' => 'required|string',
            'payment_method' => 'required|in:khqr,cod',
        ]);

        $payment = $request->payment_method;
        
        // Calculate total for session
        $cart = session()->get('cart', []);
        $buyNowItem = session()->get('buy_now_item');
        $items = $cart;
        if ($buyNowItem) { $items[] = $buyNowItem; }
        $total = collect($items)->sum(fn($i) => $i['price'] * $i['qty']);

        // Store order info in session for notification
        session([
            'order_name' => $request->name,
            'order_phone' => $request->phone,
            'order_location' => $request->location,
            'payment_method' => $payment,
            'payment_price' => $total,
            'telegram_sent' => false
        ]);

        if ($payment === 'khqr') {
            return redirect()->route('payment');
        }

        // COD
        session()->forget(['cart', 'buy_now_item']);
        return redirect()->route('checkout.success')
               ->with('success', 'Order placed successfully (Cash on Delivery)');
    }

    public function payment()
    {
        $cart = session()->get('cart', []);
        $buyNowItem = session()->get('buy_now_item');
        
        $items = $cart;
        if ($buyNowItem) {
            $items[] = $buyNowItem;
        }

        $total = collect($items)->sum(fn($i) => $i['price'] * $i['qty']);

        if ($total <= 0) {
            return redirect()->route('home');
        }

        // Generate KHQR
        $individualInfo = new IndividualInfo(
            bakongAccountID: 'thet_panhayuth@bkrt',
            merchantName: 'Thet panhayuth',
            merchantCity: 'PHNOM PENH',
            currency: KHQRData::CURRENCY_KHR,
            amount: $total,
        );

        $khqr = BakongKHQR::generateIndividual($individualInfo);

        return view('payment', [
            'qrData' => $khqr->data,
            'price'  => $total,
        ]);
    }

    public function success()
    {
        return view('payment-success', [
            'name'  => session('order_name', 'Valued Customer'),
            'price' => session('payment_price', 0), // Note: might need to fix session key for total
        ]);
    }
}
