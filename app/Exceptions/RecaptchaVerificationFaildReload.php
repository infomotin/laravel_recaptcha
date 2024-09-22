<?php

namespace App\Exceptions;

use Exception;

class RecaptchaVerificationFaildReload extends Exception
{
    public function __construct()
    {
        parent::__construct();
    }

    public function render()
    {
        // return response()->json([
        //     'message' => 'Invalid Recaptcha Token',
        //     'success' => false
        // ], 401);
        return redirect()->back()->with('status', 'Invalid Recaptcha Score');
    }
}
