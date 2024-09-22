<?php

namespace App\Http\Middleware;

use App\Exceptions\RecaptchaRequestFaild;
use App\Exceptions\RecaptchaVerificationFaildReload;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VerifyRecaptchaTokenReload
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('recaptcha.secret'),
            // 'secret' => 'abcd',
            'response' => $request->recaptcha_token,
            'remoteip' => $request->ip(),
        ])->object();
        if($response->success !== true) {

            throw new RecaptchaRequestFaild('Invalid Recaptcha Token');

            // return response()->json([
            //     'message' => 'Invalid Recaptcha Token',
            //     'success' => false
            // ], 401);
        }
        if($response->score <= 0.8) {

            throw new RecaptchaVerificationFaildReload('Invalid Recaptcha Score');
            // return response()->json([
            //     'message' => 'Invalid Recaptcha Score',
            //     'success' => false
            // ], 401);
        }
        // dd($response->success, $response->score);
        return $next($request);
    }
}
