<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use Validator;

class UserController extends AdminSectionController
{
    protected $controllerType = 'user';
    protected $userList;
    protected $permissionList;

    public function __construct(User $user)
    {
        // Initialise parent constructor.
        parent::__construct();

        // Get Staff List.
        $this->userList = $user->getUsers();

        // Get Permission List.
        $this->permissionsList = Permission::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        // Validate then insert if successful.
        $request->validate($this->insertValidationOptions);

        $user->user_display_name = $request->display_name;
        $user->user_first_name = $request->user_first_name;
        $user->user_last_name = $request->user_last_name;
        $user->user_email = $request->user_email;
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
