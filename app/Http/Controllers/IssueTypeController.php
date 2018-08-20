<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IssueType;
use App\Traits\AdminTrait;
use Validator;

class IssueTypeController extends Controller
{
    private $configData;
    private $adminSections;
    private $issueList;
    private $insertValidateOptions;

    use AdminTrait;

    public function __construct(IssueType $issueType)
    {
        // Get Issue List.
        $this->issueList = $issueType->getIssueTypes();

        // Require authentication.
        $this->middleware('auth');

        // Get global config.
        $this->configData = $this->getGlobalConfig();

        // Get admin section names and routes for front end.
        $this->adminSections = $this->getAdminSections();

        // Set insert fields as required for validation.
        $formFields = ['issue_name'];

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
        // Issue Type home page.
        // Since we have a single page for adding and editing these records, no need to use the create method.

        return view('admin.issue_type', [
            'config' => $this->configData,
            'adminSections' => $this->adminSections,
            'issueList' => $this->issueList
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
    public function store(Request $request, IssueType $issueType)
    {
        // Validate then insert if successful.
        $request->validate($this->validationOptions);

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
    public function batchUpdate(Request $request)
    {
        /**
        TODO:
        - Process updates
        - Process deletions
        - Compile feedback for front end
        - Return view with data
        */

        // Validate all fields in the request - all required and must be unique.
        Validator::make($request->all(), [
            'issue_type.*.name' => 'required'
        ])->validate();


        // Check for any items tagged for deletion. If found, add to array for batch deletion.
        $deleteArray = [];

        foreach ($request->issue_type as $item => $fieldValues) {
            if (array_key_exists('delete', $fieldValues)) {
                $deleteArray[$fieldValues['original_value']] = $fieldValues['id'];
            }
        }

        // Determine which fields have changed, and prepare array for batch update.
        $updateArray = [];        

        foreach ($request->issue_type as $item => $fieldValues) {
            if ($fieldValues['original_value'] !== $fieldValues['name']) {
                $updateArray[$fieldValues['id']]['original_value'] = $fieldValues['original_value'];
                $updateArray[$fieldValues['id']]['new_value'] = $fieldValues['name'];
            }
        }

        // Just return with warning if no items were updated or deleted.
        if (empty($deleteArray) && empty($updateArray)) {
            return redirect()->route('issue_types.index')->with('warning', 'No items to update or delete.');
        }

        // Unset any items tagged for deletion so we don't try to update them.
        // This may occur in a scenario where the field is edited and 'Delete' is also ticked.
        foreach ($deleteArray as $issueTypeId) {
            unset($updateArray[$issueTypeId]);
        }

        // Process the updates (if there are any).
        if (! empty($updateArray)) {
            foreach ($updateArray as $issueTypeId => $updatedValues) {
                IssueType::where('id', $issueTypeId)->update(['issue_name' => $updatedValues['new_value']]);
            }
        }

        // Process the deletions (if there are any).
        if (! empty($deleteArray)) {
            IssueType::destroy($deleteArray);
        }

        // Build sucess messages to pass back to the front end.
        $successMessage = '<p>Success! The following updates were made:</p>';

        if (! empty($updateArray)) {
            $successMessage .= '<p>'. count($updateArray).' record(s) were updated:</p>';
            
            $successMessage .= '<ul>';

            foreach ($updateArray as $issueTypeId => $updatedValues) {
                $successMessage .= '<li>'. $updatedValues['original_value'] .' updated to '. $updatedValues['new_value'] .'</li>';
            }
            $successMessage .= '</ul>';
        }

        if (! empty($deleteArray)) {
            $successMessage .= '<p>'. count($deleteArray).' record(s) were deleted:</p>';
            $successMessage .= '<ul>';

            foreach ($deleteArray as $itemName => $itemId) {
                $successMessage .= '<li>'. $itemName .'</li>';
            }

            $successMessage .= '</ul>';   
        }

        return redirect()->route('issue_types.index')->with('success', $successMessage);
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
