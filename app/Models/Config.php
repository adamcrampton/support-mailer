<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    // Retrieve default config.
    public function getConfig()
    {
    	// Return the config for the front end - ensure we only return a single record (there should not be multiple records though).
    	return Config::where('config_name', 'global')->first();
    }

    // Config has one default provider.
    public function provider()
    {
    	return $this->hasOne('App\Models\Provider', 'id', 'default_provider_fk');
    }
}
