<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Provider;
use App\Models\IssueType;
use App\Models\StaffMember;

class PageController extends Controller
{
    // Serve the form page.
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
}
