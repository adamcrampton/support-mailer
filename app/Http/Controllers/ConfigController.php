<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Provider;
use App\Models\User;
use App\Traits\AdminTrait;

class ConfigController extends AdminSectionController
{
    protected $controllerType = 'config';
    private $bounceReason = 'Sorry, you require admin access to manage the global config.';

    public function __construct(User $user)
    {
        // Initialise parent constructor.
        parent::__construct();

        // Get a list of providers.
        $this->providerList = Provider::all();

        // Initalise any Model dependencies.
        $this->$user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        // Check user is authorised.
        if ($user->cant('index', $user)) {
            return redirect()->route('admin.index')->with('warning', $this->bounceReason);
        }

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
    public function update(Request $request, $id, User $user)
    {
        // Check user is authorised.
        if ($user->cant('update', $user)) {
            return redirect()->route('admin.index')->with('warning', $this->bounceReason);
        }

        // Validate then update the Global Config.
        $request->validate($this->updateValidationOptions);

        // Set up values for update.
        $updateArray = [
            'config_name' => 'global',
            'form_heading' => $request->form_heading,
            'form_title' => $request->form_title,
            'intro_html' => $request->intro_html,
            'default_provider_fk' => $request->provider_list,
            'show_multiple_providers' => $request->show_multiple_providers,
            'use_staff_list' => $request->use_staff_list
        ];

        // Validation has passed if we've got this far, proceed with the update.
        Config::where('id', $id)
            ->update($updateArray);

        return redirect()->route('config.index')->with('success', 'Success! Global Config has been updated.');
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
