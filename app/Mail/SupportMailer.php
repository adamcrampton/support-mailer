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
    // private $submitResponse;

    // use Queueable, SerializesModels;

    // /**
    //  * Build the message.
    //  *
    //  * @return $this
    //  */
    // public function build($submitResponse)
    // {
    //     $this->submitResponse = $submitResponse;

    //     $fieldData = $this->getFieldData();

    //     // return $this->view('mail.support_request');
    // }

    // public function getFieldData(Config $config, Provider $provider)
    // {
    //     dd($this->submitResponse);

    //     // Determine which fields need to be populated based on current config, and grab the data from the appropriate source.
    //     $configData = $config->getConfig();

    //     // Set field data.
    //     $fieldData = [];

    //     // Set provider field.
    //     $fieldData['provider'] = ($configData->showMultipleProviders) ? 'db' : 'request';
    //     // $this->fieldData[]
    // }

}
