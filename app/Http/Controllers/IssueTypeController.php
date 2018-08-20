<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IssueType;
use App\Traits\AdminTrait;

class IssueTypeController extends Controller
{
    private $configData;
    private $adminSections;
    private $issueList;

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
        - Validate
        - Process updates
        - Process deletions
        - Compile feedback for front end
        - Return view with data
        */

        dd($request->all());
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
