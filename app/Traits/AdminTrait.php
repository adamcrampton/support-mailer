<?php

namespace App\Traits;

use App\Models\Config;

trait AdminTrait
{
	public function getAdminSections()
	{
		// Return list of admin sections.
		// Prepare admin sections 'name' => 'routename'.
        return [
            'Global Config' => 'config',
            'Issue Types' => 'issue_types',
            'Providers' => 'providers',
            'Staff Members' => 'staff_members',
        ];
	}

    public function getGlobalConfig()
    {
        // Return Global Config.
        $config = new Config;

        return $config->getConfig();
    }
}