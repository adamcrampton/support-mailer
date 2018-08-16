<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Config;
use App\Models\Provider;

class SupportMailer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build($fieldArray)
    {
        return $this->from($fieldArray['email'])
            ->view('mail.support_request')
            ->with($fieldArray);
    }
}
