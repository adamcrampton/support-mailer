<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmissionLog;
use App\Models\User;
use App\Policies\SubmissionLogPolicy;
use Carbon\Carbon;
use Validator;

class SubmissionLogController extends AdminSectionController
{
    protected $controllerType = 'submissionLog';
    protected $logData;

    public function __construct(SubmissionLog $submissionLog)
    {
        // Initialise parent constructor.
        parent::__construct();

        // Get Issue List.
        $this->logData = $submissionLog->getLogData();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Return log data.
        return view('admin.submission_log', [
            'config' => $this->configData,
            'adminSections' => $this->adminSections,
            'logData' => $this->logData
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
