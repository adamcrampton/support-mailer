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
        $message = $this->view('mail.support_request')
                ->from($this->emailFrom[0], $this->emailFrom[1])
                ->subject($this->emailSubject);

        // Process and attach files if they exist in the request.
        if (! empty($this->fieldArray['uploaded_files'])) {
            // Loop through and set the filename for each.
            foreach ($this->fieldArray['uploaded_files'] as $file_uploads => $file) {
                $message->attach($file, [
                    'as' => $file->getClientOriginalName()
                ]);
            }

            unset($this->fieldArray['uploaded_files']);
        }

        $message->with($this->fieldArray);

        return $message;
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
