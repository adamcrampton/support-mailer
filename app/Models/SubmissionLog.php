<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'staff_name',
    	'staff_email',
    	'staff_phone',
    	'provider_name_fk',
    	'contact_method',
    	'issue_type_fk',
    	'details_field',
    	'email_sent',
    	'errors'
    ];

    public function getLogData()
    {
        return SubmissionLog::all();
    }

    // Eloquent relationship bindings.
    public function provider() {
        return $this->hasOne('App\Models\Provider', 'id', 'provider_name_fk');
    }

    public function issueType() {
        return $this->hasOne('App\Models\IssueType', 'id', 'issue_type_fk');
    }
}
