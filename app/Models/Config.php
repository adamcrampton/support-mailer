<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    // Retrieve default config.
    public function getConfig()
    {
    	return Config::where('config_name', 'global')->first();
    }
}
