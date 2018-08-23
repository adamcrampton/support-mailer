<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use App\Policies\UserPolicy;
use Hash;
use Validator;

class UserController extends AdminSectionController
{
    protected $controllerType = 'user';
    protected $userList;
    protected $permissionList;
    private $bounceReason = 'Sorry, you require admin access to manage users.';

    public function __construct(User $user)
    {
        // Initialise parent constructor.
        parent::__construct();

        // Get User List.
        $this->userList = $user->getUsers()->sortBy('user_name');

        // Get Permission List.
        $this->permissionList = Permission::all();
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

        // User Management home page.
        return view('admin.user', [
            'config' => $this->configData,
            'adminSections' => $this->adminSections,
            'userList' => $this->userList,
            'permissionList' => $this->permissionList
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
    public function store(Request $request, User $user)
    {
        // Check user is authorised.
        if ($user->cant('create', $user)) {
            return redirect()->route('admin.index')->with('warning', $this->bounceReason);
        }

        // Validate then insert if successful.
        $request->validate($this->insertValidationOptions);

        $user->user_name = $request->user_name;
        $user->user_first_name = $request->user_first_name;
        $user->user_last_name = $request->user_last_name;
        $user->user_email = $request->user_email;
        $user->password = Hash::make($request->user_password);
        $user->permission_fk = $request->permission_list;

        $user->save();

        // Return to index with success message.
        return redirect()->route('users.index')->with('success', 'Success! New User <strong>' . $request->user_display_name . '</strong> has been added.');
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
    public function batchUpdate(Request $request, User $user)
    {
        // Check user is authorised.
        if ($user->cant('update', $user)) {
            return redirect()->route('admin.index')->with('warning', $this->bounceReason);
        }

        // Run each row through the validator.
        Validator::make($request->all(), $this->updateValidationOptions)->validate();

        // Check for any items tagged for deletion. If found, add to array for batch deletion.
        $deleteArray = $this->buildDeleteArray($request, 'user');

        // Determine which fields have changed, and prepare array for batch update.
        $updateArray = $this->buildUpdateArray($request, 'user', ['user_name', 'user_first_name', 'user_last_name', 'user_email']);   

        // Just return with warning if no items were updated or deleted.
        $this->checkForRecordChanges($deleteArray, $updateArray, 'users.index');

        // Unset any items tagged for deletion so we don't try to update them.
        // This may occur in a scenario where the field is edited and 'Delete' is also ticked.
        $updateArray = $this->unsetDeletedItemsFromUpdateArray($deleteArray, $updateArray);

        // Process the updates (if there are any).
        if (! empty($updateArray)) {
            foreach ($updateArray as $userId => $updatedValues) {
                foreach ($updatedValues as $value) {
                    User::where('id', $userId)->update([
                        $value['column_name'] => $value['new_value']
                    ]);
                }          
            }
        }

        // Process the deletions (if there are any).
        // Note we tag them with a 0 status to prevent orphaned records.
        if (! empty($deleteArray)) {
            // Set each item status.
            User::whereIn('id', $deleteArray)->update([
                'user_status' => 0
            ]);
        }

        // Build sucess messages to pass back to the front end.
        $successMessage = $this->buildSuccessMessage($deleteArray, $updateArray);

        return redirect()->route('users.index')->with('success', $successMessage);
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
