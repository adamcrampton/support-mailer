<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SupportMailer extends Mailable
{
    use Queueable, SerializesModels;

    private $fieldArray;
    private $emailFullName;
    private $emailSubject;
    private $emailFrom;
    private $emailReplyTo;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {     
        return $this->from($this->emailFrom[0], $this->emailFrom[1])
            ->subject($this->emailSubject)
            ->view('mail.support_request')
            ->with($this->fieldArray);
    }

    public function buildConfig($fieldArray)
    {
        // Since we have a lot of incoming data, we need to set it before calling the build method.
        $this->fieldArray = $fieldArray;
        $this->emailFullName = $fieldArray['first_name'] . ' ' . $fieldArray['last_name'];
        $this->emailSubject = "Support Request from $this->emailFullName";
        $this->emailFrom = [$fieldArray['email'], $this->emailFullName];
    }
}
