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
		SEEDER_USER_NAME = 'Your Name'
		SEEDER_USER_EMAIL = your.email@domain.com
        SEEDER_USER_PASSWORD = yourpassword
        */
		DB::table('users')->insert([
            'name' => env('SEEDER_USER_NAME'),
			'email' => env('SEEDER_USER_EMAIL'),
        	'password' => Hash::make((env('SEEDER_USER_PASSWORD')))
        ]);
    }
}
