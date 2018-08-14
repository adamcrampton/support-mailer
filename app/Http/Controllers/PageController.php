<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // Serve the form page.
    public function index ()
    {
    	return view('index');
    }
}
