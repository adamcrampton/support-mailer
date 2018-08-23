<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffMember extends Model
{
	protected $fillable = ['staff_first_name', 'staff_last_name', 'staff_name', 'staff_email', 'staff_status'];

    // Get all staff member details.
    public function getStaffMembers()
    {
    	return StaffMember::where('staff_status', 1)->get();
    }
}
