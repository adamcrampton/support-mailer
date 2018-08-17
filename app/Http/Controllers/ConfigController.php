<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Provider;
use App\Traits\AdminTrait;

class ConfigController extends Controller
{
    private $configData;
    private $adminSections;
    private $providersList;
    private $validationOptions;

    use AdminTrait;

    public function __construct()
    {
        // Get global config.
        $this->configData = $this->getGlobalConfig();

        // Get admin section names and routes for front end.
        $this->adminSections = $this->getAdminSections();

        // Get a list of providersList.
        $this->providerList = Provider::all();

        // Set all fields as required for validation.
        $formFields = ['form_heading', 'form_title', 'intro_html', 'provider_list', 'show_multiple_providers', 'use_staff_list'];

        foreach ($formFields as $field) {
            $this->validationOptions[$field] = 'required';
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Global Config home page.
        return view('admin.config', [
            'config' => $this->configData,
            'adminSections' => $this->adminSections,
            'providerList' => $this->providerList
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
        //
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
        // Validate then update the Global Config.
        $request->validate($this->validationOptions);

        dd('passed');
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
