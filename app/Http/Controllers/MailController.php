<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupportMailer;

class MailController extends Controller
{
    public function send()
    {
    	$mailDetails = new \stdClass();
        $mailDetails->sender = 'SenderUserName';
        $mailDetails->receiver = 'ReceiverUserName';
 
        Mail::to("receiver@example.com")->send(new SupportMailer($mailDetails));
    }
}
