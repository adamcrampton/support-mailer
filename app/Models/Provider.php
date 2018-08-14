<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    // Get all providers.
    public function getProviders()
    {
    	return Provider::all();
    }
}
