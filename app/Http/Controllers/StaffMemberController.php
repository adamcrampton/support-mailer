<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StaffMember;
use App\Models\User;
use App\Policies\StaffMemberPolicy;
use Validator;

class StaffMemberController extends AdminSectionController
{
    protected $controllerType = 'staffMember';
    protected $staffList;
    private $bounceReason = 'Sorry, you require editor access or higher to manage staff members.';

    public function __construct(StaffMember $staffMember)
    {
        // Initialise parent constructor.
        parent::__construct();

        // Get Staff List.
        $this->staffList = $staffMember->getStaffMembers()->sortBy('staff_name');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StaffMember $staffMember, User $user)
    {
        // Check user is authorised.
        if ($user->cant('index', $staffMember)) {
            return redirect()->route('admin.index')->with('warning', $this->bounceReason);
        }

        // Staff Member home page.
        return view('admin.staff_member', [
            'config' => $this->configData,
            'adminSections' => $this->adminSections,
            'staffList' => $this->staffList
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
    public function store(Request $request, StaffMember $staffMember, User $user)
    {
        // Check user is authorised.
        if ($user->cant('create', $staffMember)) {
            return redirect()->route('admin.index')->with('warning', $this->bounceReason);
        }

        // Validate then insert if successful.
        $request->validate($this->insertValidationOptions);

        $staffMember->staff_name = $request->staff_name;
        $staffMember->staff_first_name = $request->staff_first_name;
        $staffMember->staff_last_name = $request->staff_last_name;
        $staffMember->staff_email = $request->staff_email;


        $staffMember->save();

        // Return to index with success message.
        return redirect()->route('staff_members.index')->with('success', 'Success! New Staff Member <strong>' . $request->staff_name . '</strong> has been added.');
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
    public function batchUpdate(Request $request, User $user, StaffMember $staffMember)
    {
        // Check user is authorised.
        if ($user->cant('update', $staffMember)) {
            return redirect()->route('admin.index')->with('warning', $this->bounceReason);
        }

        // Run each row through the validator.
        Validator::make($request->all(), $this->updateValidationOptions)->validate();

        // Check for any items tagged for deletion. If found, add to array for batch deletion.
        $deleteArray = $this->buildDeleteArray($request, 'staff');

        // Determine which fields have changed, and prepare array for batch update.
        $updateArray = $this->buildUpdateArray($request, 'staff', ['staff_name', 'staff_first_name', 'staff_last_name', 'staff_email']);   

        // Just return with warning if no items were updated or deleted.
        $this->checkForRecordChanges($deleteArray, $updateArray, 'staff_members.index');

        // Unset any items tagged for deletion so we don't try to update them.
        // This may occur in a scenario where the field is edited and 'Delete' is also ticked.
        $updateArray = $this->unsetDeletedItemsFromUpdateArray($deleteArray, $updateArray);

        // Process the updates (if there are any).
        if (! empty($updateArray)) {
            foreach ($updateArray as $staffMemberId => $updatedValues) {
                foreach ($updatedValues as $value) {
                    StaffMember::where('id', $staffMemberId)->update([
                        $value['column_name'] => $value['new_value']
                    ]);
                }          
            }
        }

        // Process the deletions (if there are any).
        // Note we tag them with a 0 status to prevent orphaned records.
        if (! empty($deleteArray)) {
            // Set each item status.
            StaffMember::whereIn('id', $deleteArray)->update([
                'staff_status' => 0
            ]);
        }

        // Build sucess messages to pass back to the front end.
        $successMessage = $this->buildSuccessMessage($deleteArray, $updateArray);

        return redirect()->route('staff_members.index')->with('success', $successMessage);
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
