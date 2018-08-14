<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;

class PageController extends Controller
{


    // Serve the form page.
    public function index(Config $config)
    {
    	// Fetch the config so we know what to display.
    	$configData = $config->getConfig();

    	return view('index', ['config' => $configData]);
    }
}
