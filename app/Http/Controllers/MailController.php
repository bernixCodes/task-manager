<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendWelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class MailController extends Controller
{
   public function sendEmail(){
    try {
        $toEmailAddress = 'bernyx.owusu@gmail.com';
        $welcomeMessage = 'Welcome to Task Manager App';
        Mail::to($toEmailAddress)->send(new SendWelcomeMail($welcomeMessage));
        return response()->json(['message' => 'Email sent successfully'], 200);
       
    } catch (\Exception $e) {
        Log::error("Unable to send email: " . $e->getMessage());
        return response()->json(['message' => 'Unable to send email'], 500);
    }
   }
}
