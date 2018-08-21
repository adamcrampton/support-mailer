<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffMember extends Model
{
    // Get all staff member details.
    public function getStaffMembers()
    {
    	return StaffMember::all()->sortBy('first_name');
    }
}
