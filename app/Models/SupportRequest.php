<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubmissionLog;
use App\Models\StaffMember;
use App\Models\IssueType;

class SupportRequest extends Model
{
    public function buildFieldArray($request, $configData)
    {
        // Build a master array of data so that we can populate the email template.
        // Query the db based on default or selection.
        if ($this->fieldConfig['provider'] === 'db') {
            // If providers were fetched from the db for the front end, then we must use the selection to find the provider data.
            $providerDetails = Provider::where('id', $request->provider_list)->first();
        } else {
            // Otherwise, we grab the default provider details.
            $providerDetails = Provider::where('id', $configData->default_provider_fk)->first();
        }

        // Add details to the array.
        $fieldArray['provider_details'] = $providerDetails;
        $fieldArray['provider_name'] = $providerDetails->provider_name;
        $fieldArray['provider_email'] = $providerDetails->provider_email;
        $fieldArray['provider_name_fk'] = $providerDetails->id;

        // Fetch staff details based on input values from front end selection, or matching ID in the db.
        if ($this->fieldConfig['staff'] === 'request') {
            $fieldArray['first_name'] = $request->first_name;
            $fieldArray['last_name'] = $request->last_name;
            $fieldArray['email'] = $request->email;
        } else {
            // Query the db only once.
            $staffDetails = StaffMember::where('id', $request->staff_list)->first();

            // Add details to the array.
            $fieldArray['first_name'] = $staffDetails->staff_first_name;
            $fieldArray['last_name'] = $staffDetails->staff_last_name;
            $fieldArray['email'] = $staffDetails->staff_email;
        }

        // Set issue type details.
        $issueDetails = IssueType::where('id', $request->issue_type)->first();
        $fieldArray['issue'] = $issueDetails->issue_name;
        $fieldArray['issue_type_fk'] = $issueDetails->id;

        // Add phone number if required.
        if ($request->preferred_contact === 'phone') {
            $fieldArray['phone'] = $request->phone_number;
        } else {
            $fieldArray['phone'] = 'Not applicable';
        }

        // These fields are just pulled from the request.
        $fieldArray['preferred_contact'] = $request->preferred_contact;
        $fieldArray['details'] = $request->issue_details;



        $fieldArray['attachments'] = $request->attachments;

        return $fieldArray;
    }

    public function logResults($mailFailures, $fieldArray)
    {
        // Encode failures - this will be an empty object if it was successful.
        $failures = json_encode($mailFailures);

        // Write to the log table.
        $insertValues = [
            'staff_name' => $fieldArray['first_name'] . ' ' . $fieldArray['last_name'],
            'staff_email' => $fieldArray['email'],
            'staff_phone' => $fieldArray['phone'],
            'provider_name_fk' => $fieldArray['provider_name_fk'],
            'contact_method' => $fieldArray['preferred_contact'],
            'issue_type_fk' => $fieldArray['issue_type_fk'],
            'details_field' => $fieldArray['details'],
            'email_sent' => empty($mailFailures),
            'errors' => $failures
        ];

        SubmissionLog::create($insertValues);
    }
}
