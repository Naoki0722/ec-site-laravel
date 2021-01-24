<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripesController extends Controller
{
    public function createSession(Request $request)
    {
        \Stripe\Stripe::setApiKey('sk_test_51I9UrdGfr486TDLvT9CWBixBnxe6errLRb8HnNPmbFqd4lZLWz3gaohcWQ3x5yEKniYJQxorGyGqbFD3tHljw3XA00KUvnedDM');
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => 'T-shirt',
                    ],
                    'unit_amount' => 2000,
                ],
                'description' => 'テスト商品です',
                'images' => 'https://topseller.style/wp-content/uploads/2018/07/gazou.jpg',
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'https://example.com/success',
            'cancel_url' => 'https://example.com/cancel',
        ]);
        return response()->json([
            'id' => $session->id,
            'message' => 'success'
        ], 200);
    }
}
