<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    private $globalConfig;

    // Retrieve default config.
    public function getConfig()
    {
    	// Return the config for the front end - ensure we only return a single record (there should not be multiple records though).
    	$this->globalConfig = Config::where('config_name', 'global')->first();

        return $this->globalConfig;
    }

    // Determine where to fetch email field data from, depending on global config.
    public function getFieldConfig() {
        // Set up array.
        $fieldConfig = [];

        // Go through the options.
        $fieldConfig['provider'] = $this->globalConfig->show_multiple_providers ? 'db' : 'request';
        $fieldConfig['staff'] = $this->globalConfig->use_staff_list ? 'db' : 'request';

        return $fieldConfig;
    }

    // Config has one default provider.
    public function provider()
    {
    	return $this->hasOne('App\Models\Provider', 'id', 'default_provider_fk');
    }
}
