<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add default config.
        DB::table('configs')->insert([
            'config_name' => 'global',
            'form_heading' => 'Support Mailer',
            'form_title' => 'Create your support ticket here!',
        	'intro_html' => '<p>Here is the default intro text, which will sit above the form.</p>',
        	'default_provider_fk' => 1,
        	'show_multiple_providers' => 1,
        	'use_staff_list' => 1,
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
