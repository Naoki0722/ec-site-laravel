<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Http\Request;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = app('firebase.auth');
        $token = $request->token;
        $verifiedIdToken = $auth->verifyIdToken($token);
        $uid = $verifiedIdToken->getClaim('sub');
        $user = User::where('user_id', $uid)->first();
        if($user->role > 5) {
            // return redirect('/');
            abort(403, '管理者権限がありません。');
        }
        return $next($request);
    }
}
