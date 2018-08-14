<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StaffMembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add dummy staff member.
        DB::table('staff_members')->insert([
            'staff_name' => 'Example Staff',
            'staff_email' => 'staff.member@example.com',
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
