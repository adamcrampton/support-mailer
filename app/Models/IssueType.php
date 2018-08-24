<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueType extends Model
{
	protected $fillable = ['issue_name', 'issue_status'];

    // Get all issue types.
    public function getIssueTypes()
    {
    	return IssueType::where('issue_status', 1)->get();
    }

    public function getDeletedIssueTypes()
    {
        return IssueType::where('issue_status', 0)->get();
    }

    // Eloquent relationship bindings.
    public function submissionLog()
    {
    	return $this->hasMany('App\Models\SubmissionLog', 'id');
    }
}
