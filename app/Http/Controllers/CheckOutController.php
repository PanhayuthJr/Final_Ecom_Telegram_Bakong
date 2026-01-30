<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Http\Controllers\HomeController;

class CheckoutController extends Controller
{
    private function getCart()
    {
        if (Auth::check()) {
            $dbCart = Cart::where('user_id', Auth::id())->get();
            $products = HomeController::getProducts();
            $cart = [];
            foreach ($dbCart as $item) {
                $product = collect($products)->firstWhere('id', $item->product_id);
                if ($product) {
                    $cart[$item->product_id] = [
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'qty' => $item->quantity,
                        'image' => $product['image']
                    ];
                }
            }
            return $cart;
        }
        return session()->get('cart', []);
    }

    private function clearPurchasedItems($items) 
    {
        $ids = array_column($items, 'id'); // Assuming mapped items have 'id'
        
        // Items from cart are keyed by product_id in getCart, but let's be safe.
        // The structure from getCart is [ productId => [ 'id' => productId, ... ] ]
        // So we can use the keys or the 'id' field.
        
        if (Auth::check()) {
             Cart::where('user_id', Auth::id())->whereIn('product_id', $ids)->delete();
        } else {
             $cart = session()->get('cart', []);
             foreach($ids as $id) {
                 unset($cart[$id]);
             }
             session()->put('cart', $cart);
        }
    }

    public function index(Request $request)
    {
        $cart = $this->getCart();
        
        // Handle selective checkout from cart
        if ($request->has('selected_items')) {
            $selectedIds = $request->input('selected_items');
            // Filter
            $cart = array_intersect_key($cart, array_flip($selectedIds));
            
            // Persist selection
            session()->put('checkout_selected_ids', $selectedIds);
            
            session()->forget('buy_now_item');
        }

        $buyNowItem = session()->get('buy_now_item');
        
        $items = $cart;
        
        // If persisted selection and no buy-now
        if (!$buyNowItem && session()->has('checkout_selected_ids')) {
             $selectedIds = session()->get('checkout_selected_ids');
             $fullCart = $this->getCart();
             $items = array_intersect_key($fullCart, array_flip($selectedIds));
        }

        if ($buyNowItem) {
            $items = [$buyNowItem];
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
        
        // Calculate items
        $items = $this->getCart();
        $buyNowItem = session()->get('buy_now_item');
        
        if ($buyNowItem) { 
            $items = [$buyNowItem]; 
        } elseif (session()->has('checkout_selected_ids')) {
            $selectedIds = session()->get('checkout_selected_ids');
            $items = array_intersect_key($items, array_flip($selectedIds));
        }
        
        // Snapshot for Payment/Success steps
        session(['pending_checkout_items' => $items]);

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
        if ($buyNowItem) {
            session()->forget('buy_now_item');
        } else {
            $this->clearPurchasedItems($items);
            session()->forget('checkout_selected_ids');
        }
        
        session()->forget('pending_checkout_items');

        return redirect()->route('checkout.success')
               ->with('success', 'Order placed successfully (Cash on Delivery)');
    }

    public function payment()
    {
        $items = session('pending_checkout_items', []);
        
        // Fallback or validation
        if (empty($items)) {
             // Fallback to recalculate if session expired? 
             // Ideally valid flow goes through process()
             return redirect()->route('checkout');
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
        if (session('payment_method') === 'khqr') {
             if (session()->has('buy_now_item')) {
                session()->forget('buy_now_item');
            } else {
                $items = session('pending_checkout_items', []);
                if (!empty($items)) {
                    $this->clearPurchasedItems($items);
                }
                session()->forget('checkout_selected_ids');
            }
            session()->forget('pending_checkout_items');
        }
        
        return view('payment-success', [
            'name'  => session('order_name', 'Valued Customer'),
            'price' => session('payment_price', 0), 
        ]);
    }
}
