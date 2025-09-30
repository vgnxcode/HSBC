<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use vgn\Mail\sendforgotpwdotp;

class TestEmailController extends Controller
{
    public function testing(Request $request)
    {
        // Prepare the data for the email
        $data = [
            'subject' => 'Test Forgot Password OTP',
            // Other data for the email, if required
        ];

        // Instantiate the sendforgotpwdotp mail class
        $mail = new sendforgotpwdotp($data);

        // Set the recipient email address
        $recipientEmail = 'nishanthprabu@vgn.in';

        // Send the test email
        Mail::to($recipientEmail)->send($mail);

        return "Test email sent successfully!";
    }
}
