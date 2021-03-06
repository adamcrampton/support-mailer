<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
use App\Models\User;
use App\Policies\ProviderPolicy;
use Validator;

class ProviderController extends AdminSectionController
{
    protected $controllerType = 'provider';
    protected $providerList;
    protected $deletedProviderList;
    private $bounceReason = 'Sorry, you require editor access or higher to manage providers.';

    public function __construct(Provider $provider)
    {
        // Initialise parent constructor.
        parent::__construct();

        // Get Provider List.
        $this->providerList = $provider->getProviderList()->sortBy('provider_name');

        // Get Deleted Providers.
        $this->deletedProviderList = $provider->getDeletedProviderList()->sortBy('provider_name');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Provider $provider, User $user)
    {
        // Check user is authorised.
        if ($user->cant('index', $provider)) {
            return redirect()->route('admin.index')->with('warning', $this->bounceReason);
        }

        // Provider home page.
        return view('admin.provider', [
            'config' => $this->configData,
            'adminSections' => $this->adminSections,
            'providerList' => $this->providerList
        ]);    
    }

    public function indexRestore(Provider $provider, User $user)
    {
        // Check user is authorised.
        if ($user->cant('index', $provider)) {
            return redirect()->route('admin.index')->with('warning', $this->bounceReason);
        }

        // Provider restore page.
        return view('admin.provider_restore', [
            'config' => $this->configData,
            'adminSections' => $this->adminSections,
            'providerList' => $this->deletedProviderList
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
    public function store(Request $request, Provider $provider, User $user)
    {
        // Check user is authorised.
        if ($user->cant('create', $provider)) {
            return redirect()->route('admin.index')->with('warning', $this->bounceReason);
        }

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
    public function batchUpdate(Request $request, User $user, Provider $provider)
    {
        // Check user is authorised.
        if ($user->cant('update', $user)) {
            return redirect()->route('admin.index')->with('warning', $this->bounceReason);
        }

        // Run each row through the validator.
        Validator::make($request->all(), $this->updateValidationOptions)->validate();

        // Check for any items tagged for deletion. If found, add to array for batch deletion.
        $deleteArray = $this->buildDeleteArray($request, 'provider');

        // Check for any items tagged for restoration. If found, add to array for batch restore.
        $restoreArray = $this->buildRestoreArray($request, 'provider');

        // Determine which fields have changed, and prepare array for batch update.
        $updateArray = $this->buildUpdateArray($request, 'provider', ['provider_name', 'provider_email']);   

        // Just return with warning if no items were updated or deleted.
        $this->checkForRecordChanges($deleteArray, $updateArray, $restoreArray, 'providers.index');

        // Unset any items tagged for deletion so we don't try to update them.
        // This may occur in a scenario where the field is edited and 'Delete' is also ticked.
        $updateArray = $this->unsetDeletedItemsFromUpdateArray($deleteArray, $updateArray, $restoreArray);

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

        // Process any deletions.
        // Note we tag them with a 0 status to prevent orphaned records.
        if (! empty($deleteArray)) {
            $deleteArray = $this->batchDelete($deleteArray);
        }

        // Process any restorations (setting 1 status).
        if (! empty($restoreArray)) {
            $batchArray = $this->batchRestore($restoreArray);
        }

        // Build sucess messages to pass back to the front end.
        $successMessage = $this->buildSuccessMessage($deleteArray, $updateArray, $restoreArray);

        return redirect()->route('providers.index')->with('success', $successMessage);
    }

    private function batchDelete($deleteArray)
    {
        // Set each item status.
        Provider::whereIn('id', $deleteArray)->update([
            'provider_status' => 0
        ]);

        return $deleteArray;
    }

    private function batchRestore($restoreArray)
    {
        // Set each item status.
        Provider::whereIn('id', $restoreArray)->update([
            'provider_status' => 1
        ]);
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
