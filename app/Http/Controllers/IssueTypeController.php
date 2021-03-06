<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IssueType;
use App\Models\User;
use App\Policies\IssueTypePolicy;
use Validator;

class IssueTypeController extends AdminSectionController
{
    protected $controllerType = 'issueType';
    protected $issueList;
    protected $deletedIssueList;
    private $bounceReason = 'Sorry, you require editor access or higher to manage issue types.';

    public function __construct(IssueType $issueType)
    {
        // Initialise parent constructor.
        parent::__construct();

        // Get Issue List.
        $this->issueList = $issueType->getIssueTypes()->sortBy('issue_name');

        // Get Deleted Issues.
        $this->deletedIssueList = $issueType->getDeletedIssueTypes()->sortBy('issue_name');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IssueType $issueType, User $user)
    {
        // Check user is authorised.
        if ($user->cant('index', $issueType)) {
            return redirect()->route('admin.index')->with('warning', $this->bounceReason);
        }

        // Issue Type home page.
        // Since we have a single page for adding and editing these records, no need to use the create method.
        return view('admin.issue_type', [
            'config' => $this->configData,
            'adminSections' => $this->adminSections,
            'issueList' => $this->issueList
        ]);
    }

    public function indexRestore(IssueType $issueType, User $user)
    {
        // Check user is authorised.
        if ($user->cant('index', $issueType)) {
            return redirect()->route('admin.index')->with('warning', $this->bounceReason);
        }

        // Issue Type restore page.
        return view('admin.issue_type_restore', [
            'config' => $this->configData,
            'adminSections' => $this->adminSections,
            'issueList' => $this->deletedIssueList
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
    public function store(Request $request, IssueType $issueType, User $user)
    {
        // Check user is authorised.
        if ($user->cant('create', $issueType)) {
            return redirect()->route('admin.index')->with('warning', $this->bounceReason);
        }

        // Validate then insert if successful.
        $request->validate($this->insertValidationOptions);

        $issueType->issue_name = $request->issue_name;

        $issueType->save();

        // Return to index with success message.
        return redirect()->route('issue_types.index')->with('success', 'Success! New Issue Type <strong>' . $request->issue_name . '</strong> has been added.');
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
    public function batchUpdate(Request $request, User $user, IssueType $issueType)
    {
        // Check user is authorised.
        if ($user->cant('update', $issueType)) {
            return redirect()->route('admin.index')->with('warning', $this->bounceReason);
        }

        // Run each row through the validator.
        Validator::make($request->all(), $this->updateValidationOptions)->validate();

        // Check for any items tagged for deletion. If found, add to array for batch deletion.
        $deleteArray = $this->buildDeleteArray($request, 'issue');

        // Check for any items tagged for restoration. If found, add to array for batch restore.
        $restoreArray = $this->buildRestoreArray($request, 'issue');

        // Determine which fields have changed, and prepare array for batch update.
        $updateArray = $this->buildUpdateArray($request, 'issue', ['issue_name']);        

        // Just return with warning if no items were updated or deleted.
        $this->checkForRecordChanges($deleteArray, $updateArray, $restoreArray, 'issue_types.index');

        // Unset any items tagged for deletion so we don't try to update them.
        // This may occur in a scenario where the field is edited and 'Delete' is also ticked.
        $updateArray = $this->unsetDeletedItemsFromUpdateArray($deleteArray, $updateArray);

        // Process the updates (if there are any).
        if (! empty($updateArray)) {
            foreach ($updateArray as $issueTypeId => $updatedValues) {
                foreach ($updatedValues as $value) {
                    IssueType::where('id', $issueTypeId)->update([
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

        return redirect()->route('issue_types.index')->with('success', $successMessage);
    }

    private function batchDelete($deleteArray)
    {
        // Set each item status.
        IssueType::whereIn('id', $deleteArray)->update([
            'issue_status' => 0
        ]);

        return $deleteArray;
    }

    private function batchRestore($restoreArray)
    {
        // Set each item status.
        IssueType::whereIn('id', $restoreArray)->update([
            'issue_status' => 1
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
