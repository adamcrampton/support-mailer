<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
use Validator;

class ProviderController extends AdminSectionController
{
    protected $controllerType = 'provider';
    protected $providerList;

    public function __construct(Provider $provider)
    {
        // Initialise parent constructor.
        parent::__construct();

        // Get Provider List.
        $this->providerList = $provider->getProviderList();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Provider home page.
        return view('admin.provider', [
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
    public function store(Request $request, Provider $provider)
    {
        // Validate then insert if successful.
        $request->validate($this->insertValidationOptions);

        $provider->provider_name = $request->provider_name;
        $provider->provider_email = $request->provider_email;

        $provider->save();

        // Return to index with success message.
        return redirect()->route('providers.index')->with('success', 'Success! New Provider <strong>' . $request->provider_name . '</strong> has been added.');
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
     * Receive an array of data from multi-row field and process a batch update.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function batchUpdate(Request $request)
    {
        // Run each row through the validator.
        Validator::make($request->all(), $this->updateValidationOptions)->validate();

        // Check for any items tagged for deletion. If found, add to array for batch deletion.
        $deleteArray = $this->buildDeleteArray($request, 'provider');

        // Determine which fields have changed, and prepare array for batch update.
        $updateArray = $this->buildUpdateArray($request, 'provider', ['provider_name', 'provider_email']);   

        // Just return with warning if no items were updated or deleted.
        $this->checkForRecordChanges($deleteArray, $updateArray, 'provider.index');

        // Unset any items tagged for deletion so we don't try to update them.
        // This may occur in a scenario where the field is edited and 'Delete' is also ticked.
        $updateArray = $this->unsetDeletedItemsFromUpdateArray($deleteArray, $updateArray);

        // Process the updates (if there are any).
        if (! empty($updateArray)) {
            foreach ($updateArray as $providerId => $updatedValues) {
                foreach ($updatedValues as $value) {
                    Provider::where('id', $providerId)->update([
                        $value['column_name'] => $value['new_value']
                    ]);
                }          
            }
        }

        // Process the deletions (if there are any).
        if (! empty($deleteArray)) {
            Provider::destroy($deleteArray);
        }

        // Build sucess messages to pass back to the front end.
        $successMessage = $this->buildSuccessMessage($deleteArray, $updateArray);

        return redirect()->route('providers.index')->with('success', $successMessage);
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
