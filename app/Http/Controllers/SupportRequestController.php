<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Config;
use App\Models\Provider;
use App\Models\IssueType;
use App\Models\StaffMember;
use App\Models\SubmissionLog;
use App\Mail\SupportMailer;

class SupportRequestController extends Controller
{
    private $configData;
    private $fieldConfig;
    private $providerList;
    private $issueList;
    private $staffMembers;
    private $validationOptions;

    public function __construct(Config $config, Provider $provider, IssueType $issueType, StaffMember $staffMember)
    {
        // Build configuration for the front end.
        // Fetch the config so we know what to display.
        $this->configData = $config->getConfig();

        // Get a list of providers if the option is set.
        $this->providerList = $this->configData->show_multiple_providers ? $provider->getProviders() : $this->configData->default_provider_fk;

        // Get a list of issue types.
        $this->issueList = $issueType->getIssueTypes();

        // Get a list of staff members if the option is set.
        $this->staffMembers = $this->configData->use_staff_list ? $staffMember->getStaffMembers() : [];

        // Set default validation options.
        $this->validationOptions['preferred_contact'] = 'required';
        $this->validationOptions['issue_type'] = 'required';
        $this->validationOptions['issue_details'] = 'required';

        // Set additional validation options based on global config.
        if (is_array($this->providerList)) { // This will be a string (default provider fk) if there's no list.
            $this->validationOptions['provider_list'] = 'required';
        }

        if (! empty($this->staffMembers)) {
            $this->validationOptions['staff_list'] = 'required';
        } else {
            $this->validationOptions['first_name'] = 'required';
            $this->validationOptions['last_name'] = 'required';
            $this->validationOptions['email'] = 'required|email';
        }

        // Set the actual fields we are going to eventually pass to the mailer.
        $this->fieldConfig = $config->getFieldConfig();
    }  

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Pass all required config to front end.
        return view('index', [
            'config' => $this->configData, 
            'providers' => $this->providerList, 
            'issueList' => $this->issueList,
            'staffMembers' => $this->staffMembers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // Since the front page is actually a form, and the only view on the public front-end, I've put this into the index method to save complication.
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SupportMailer $supportMailer)
    {
        // Set additional validation options based on any front end logic passed through.
        if ($request->preferred_contact === 'phone') {
            $this->validationOptions['phone_number'] = ['required'];
        }

        // Validate the data - a redirect with validation errors will automatically kick in if it fails.
        $request->validate($this->validationOptions);

        // Validation is successful, so let's build the data for the email template.
        $fieldArray = $this->buildFieldArray($request);

        // Pass the data into the Mailer.
        // A config method has to be run first, because build() doesn't like to take parameters.
        $supportMailer->buildConfig($fieldArray);
        $supportMailer->build();

        // Now send the completed email to the specified provider.
        Mail::to($fieldArray['provider_details']->provider_email)->send($supportMailer);

        // Log result to front end and return feedback (Mail::failures() will return an empty array if successful).
        $this->logResults(Mail::failures(), $fieldArray);

        // Redirect to front end with messaging.
        if (empty(Mail::failures())) {
            return redirect()->route('index')->with('success', 'Success! Your ticket has been submitted.');
        }

        $warningMessage = 'Sorry, we had a problem emailing your form. Please email <a href="mailto:' . $fieldArray["provider_email"] . '">' . $fieldArray['provider_email'] . '</a> directly.';

        return redirect()->route('index')->with('warning', $warningMessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function buildFieldArray($request)
    {
        // Build a master array of data so that we can populate the email template.
        // Query the db based on default or selection.
        if ($this->fieldConfig['provider'] === 'db') {
            // If providers were fetched from the db for the front end, then we must use the selection to find the provider data.
            $providerDetails = Provider::where('id', $request->provider_list)->first();
        } else {
            // Otherwise, we grab the default provider details.
            $providerDetails = Provider::where('id', $this->configData->default_provider_fk)->first();
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

        return $fieldArray;
    }

    private function logResults($mailFailures, $fieldArray)
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
