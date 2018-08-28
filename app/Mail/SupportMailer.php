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
    private $emailAttachments;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {     
        $message = $this->view('mail.support_request')
                ->from($this->emailFrom[0], $this->emailFrom[1])
                ->subject($this->emailSubject)
                ->with($this->fieldArray);

        // Process and attach files if they exist in the request.
        if (! empty($this->emailAttachments)) {
            // Loop through and set the filename for each.
            foreach ($this->emailAttachments as $attachments => $attachment) {
                $message->attach($attachment, [
                    'as' => $attachment->getClientOriginalName()
                ]);
            }
        }

        return $message;
    }

    public function buildConfig($fieldArray)
    {
        // Since we have a lot of incoming data, we need to set it before calling the build method.
        $this->fieldArray = $fieldArray;
        $this->emailFullName = $fieldArray['first_name'] . ' ' . $fieldArray['last_name'];
        $this->emailSubject = "Support Request from $this->emailFullName";
        $this->emailFrom = [$fieldArray['email'], $this->emailFullName];
        
        // Only set file attachments if submitted.
        $this->emailAttachments = (! empty($fieldArray['attachments'])) ? $fieldArray['attachments'] : []; 
    }
}
