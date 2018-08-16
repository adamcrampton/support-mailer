<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Provider;
use App\Models\IssueType;
use App\Models\StaffMember;
use App\Mail\SupportMailer;

class SupportRequestController extends Controller
{
    public $submitResponse;
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
        $this->providerList = $this->configData->show_multiple_providers ? $provider->getProviders() : [];

        // Get a list of issue types.
        $this->issueList = $issueType->getIssueTypes();

        // Get a list of staff members if the option is set.
        $this->staffMembers = $this->configData->use_staff_list ? $staffMember->getStaffMembers() : [];

        // Set default validation options.
        $this->validationOptions = [
            'preferred_contact' => [
                'required'
            ],
            'issue_type' => [
                'required'
            ]
            ,
            'issue_details' => [
                'required'
            ]
        ];

        // Set additional validation options based on global config.
        if (! empty($this->providerList)) {
            $this->validationOptions['provider_list'] = ['required'];
        }

        if (! empty($this->staffMembers)) {
            $this->validationOptions['staff_list'] = ['required'];
        } else {
            $this->validationOptions['first_name'] = ['required'];
            $this->validationOptions['last_name'] = ['required'];
            $this->validationOptions['email'] = ['required'];
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

        // Validate the data - a redirect will automatically kick in if it fails.
        $this->submitResponse = $request->validate($this->validationOptions);

        // Now fetch the data, depending on config and any front end options.
        $fieldArray = [];

        $fieldArray['provider'] = ($this->fieldConfig['provider'] === 'request') ? Provider::where('id', $this->submitResponse['provider_list'])->first()->provider_name : Provider::where('id', $this->configData->default_provider_fk)->first()->provider_name;

        $fieldArray['staff'] = ($this->fieldConfig['staff'] === 'request') ? StaffMember::where('id', $this->submitResponse['staff_list'])->first()->staff_name;

        if ($this->fieldConfig['staff'] === 'request') {

        } else {
            $fieldArray['staff'] = '';
        }        

        // TODO: Log results to table.
        // TODO: Provide success alert on view render.

        // Validation is successful - send all required data off to the mailer.
        $supportMailer->build($this->submitResponse);

        // return redirect()->route('index');

        dd('Validation succeeded, stop.');
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
}
