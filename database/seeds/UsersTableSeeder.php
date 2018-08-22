<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** 
        * Note: You must add these lines to your .env file for this Seeder to work (replace the values, obviously):
        SEEDER_USER_FIRST_NAME = 'Firstname'
        SEEDER_USER_LAST_NAME = 'Lastname'
		SEEDER_USER_DISPLAY_NAME = 'Firstname Lastname'
		SEEDER_USER_EMAIL = your.email@domain.com
        SEEDER_USER_PASSWORD = yourpassword
        */
		DB::table('users')->insert([
            'first_name' => env('SEEDER_USER_FIRST_NAME'),
            'last_name' => env('SEEDER_USER_LAST_NAME'),
            'display_name' => env('SEEDER_USER_DISPLAY_NAME'),
			'email' => env('SEEDER_USER_EMAIL'),
        	'password' => Hash::make((env('SEEDER_USER_PASSWORD'))),
            'permission_fk' => 1
        ]);
    }
}
