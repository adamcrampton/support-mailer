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
}
