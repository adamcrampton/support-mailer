<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueType extends Model
{
	protected $fillable = ['issue_name', 'issue_status'];

    // Get all providers.
    public function getIssueTypes()
    {
    	return IssueType::where('issue_status', 1)->get();
    }
}
