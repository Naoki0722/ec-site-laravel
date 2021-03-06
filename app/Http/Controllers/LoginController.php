<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = DB::table('users')->where('email', $request->email)->first();
            $message = 'DB connected & user info successfully got';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG ';
            $status = 500;
        } finally {
            return response()->json([
                'data' => $user,
                'message' => $message,
            ], $status);
        }

    }
    public function adminLogin(Request $request)
    {
        $user = DB::table('users')->where('email', $request->email)->first();
        return response()->json([
            'data' => $user,
            'message' => 'admin success login',
        ], 200);

    }
}
