<?php

namespace App\Http\Controllers;

use Dotenv\Dotenv;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;


class StripesController extends Controller
{
    public function createSession(Request $request)
    {
        // .envにキーを記載(セキュリティー対策のため)
        // $dotenv = Dotenv::createImmutable(dirname(__DIR__, 3));
        // $dotenv->load();
        // $secretKey = getenv('STRIPE_SECRET_KEY');
        $secretKey = env('STRIPE_SECRET_KEY');
        \Stripe\Stripe::setApiKey($secretKey);
        $session = Session::create([
            'shipping_address_collection' => [
                'allowed_countries' => ['JP'],
            ],
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $request->title,
                        'images' => [$request->image],
                    ],
                    'unit_amount' => $request->price,
                ],
                'description' => $request->description,
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => "https://amazing-wilson-5152ff.netlify.app/pthanks",
            'cancel_url' => 'https://amazing-wilson-5152ff.netlify.app/carts',
        ]);
        return response()->json([
            'id' => $session->id,
            'customer' => $session,
            'message' => 'success'
        ], 200);
    }
}
