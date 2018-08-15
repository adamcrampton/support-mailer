<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Provider;
use App\Models\IssueType;
use App\Models\StaffMember;

class SupportRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Config $config, Provider $provider, IssueType $issueType, StaffMember $staffMember)
    {
        // Fetch the config so we know what to display.
        $configData = $config->getConfig();

        // Get a list of providers if the option is set.
        $providerList = $configData->show_multiple_providers ? $provider->getProviders() : [];

        // Get a list of issue types.
        $issueList = $issueType->getIssueTypes();

        // Get a list of staff members if the option is set.
        $staffMembers = $configData->use_staff_list ? $staffMember->getStaffMembers() : [];

        return view('index', [
            'config' => $configData, 
            'providers' => $providerList, 
            'issueList' => $issueList,
            'staffMembers' => $staffMembers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the data.
        $request->validate([
            'provider_list' => 'required',
            'staff_list' => 'required',
            'preferred_contact' => 'required',
            'phone_number' => 'required',
            'issue_type' => 'required',
            'issue_details' => 'required'
        ]);
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
