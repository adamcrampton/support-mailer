<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	// Eloquent relationship bindings.
    public function user()
    {
    	$this->hasMany('App\Models\User', 'id');
    }
}
