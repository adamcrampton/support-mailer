<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Provider;

class PageController extends Controller
{
    // Serve the form page.
    public function index(Config $config, Provider $provider)
    {
    	// Fetch the config so we know what to display.
    	$configData = $config->getConfig();

    	// Get a list of providers if the option is set.
    	$providerList = $configData->show_multiple_providers ? $provider->getProviders() : [];

    	return view('index', ['config' => $configData, 'providers' => $providerList]);
    }
}
