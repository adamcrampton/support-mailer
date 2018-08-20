<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueType extends Model
{
    // Get all providers.
    public function getIssueTypes()
    {
    	return IssueType::all()->sortBy('issue_name');
    }
}
