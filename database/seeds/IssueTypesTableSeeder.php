<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class IssueTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert a list of default issue types.
        $defaultIssueTypes = ['Logging in', 'Computer won\'t power up', 'Computer is very slow', 'Email or Outlook', 'Printing', 'Connecting to Wi-Fi', 'Internet issues', 'Accessing shared folders or files', 'Connecting to VPN', 'Landline phone', 'Other'];

	        foreach ($defaultIssueTypes as $issueName) {
	        	DB::table('issue_types')->insert([
	            'issue_name' => $issueName,
                'issue_status' => 1,
	        	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
	        	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
	        ]);
        }
    }
}
