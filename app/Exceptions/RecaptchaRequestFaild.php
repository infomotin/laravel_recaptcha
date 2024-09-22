<?php

namespace App\Exceptions;

use Exception;

class RecaptchaRequestFaild extends Exception
{
    public function __construct()
    {
        parent::__construct('Recaptcha request faild.');
    }

    public function render()
    {
        $respons = response()->json([
            'message' => 'Invalid Recaptcha Token',
            'success' => false
        ], 401);

        return redirect()->back()->with('status', 'Invalid Request Google');
    }
}
