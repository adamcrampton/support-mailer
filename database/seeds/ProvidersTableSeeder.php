<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add default provider.
        DB::table('providers')->insert([
            'provider_name' => 'Example Provider',
            'provider_email' => 'example@test.com',
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
