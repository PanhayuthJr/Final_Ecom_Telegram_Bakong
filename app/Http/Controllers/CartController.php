<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
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
        } else {
            $cart = session()->get('cart', []);
        }

        return view('cart', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $products = HomeController::getProducts();
        $product = collect($products)->firstWhere('id', $id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        if (Auth::check()) {
            $cartItem = Cart::where('user_id', Auth::id())
                            ->where('product_id', $id)
                            ->first();

            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $id,
                    'quantity' => 1
                ]);
            }
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['qty']++;
            } else {
                $cart[$id] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'qty' => 1,
                    'image' => $product['image']
                ];
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.view')->with('success', 'Added to cart');
    }

    public function update(Request $request, $id)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->update(['quantity' => $request->qty]);
        } else {
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                $cart[$id]['qty'] = $request->qty;
                session()->put('cart', $cart);
            }
        }
        return redirect()->back();
    }

    public function remove($id)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->delete();
        } else {
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }
        return redirect()->back();
    }
}
