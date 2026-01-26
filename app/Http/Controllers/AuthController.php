<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cart;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Merge Session Cart to DB
            $sessionCart = session()->get('cart', []);
            if (!empty($sessionCart)) {
                foreach ($sessionCart as $id => $details) {
                    $cartItem = Cart::where('user_id', Auth::id())
                                    ->where('product_id', $id)
                                    ->first();

                    if ($cartItem) {
                        $cartItem->increment('quantity', $details['qty']);
                    } else {
                        Cart::create([
                            'user_id' => Auth::id(),
                            'product_id' => $id,
                            'quantity' => $details['qty']
                        ]);
                    }
                }
                session()->forget('cart');
            }

            return redirect()->intended('/catalog');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/catalog');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/catalog');
    }
}
