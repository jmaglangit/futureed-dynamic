<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class AdminTableSeeder extends Seeder
{
    public function run()
    {

        \DB::table('admins')->truncate();
        \DB::table('admins')->insert([
            [
                'user_id' => 1,
                'first_name' => 'Farrah Faye',
                'last_name' => 'Dy',
                'admin_role' => 'Super Admin',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 4,
                'first_name' => 'John Rey',
                'last_name' => 'Quiros',
                'admin_role' => 'Admin',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 7,
                'first_name' => 'Jason',
                'last_name' => 'Maglangit',
                'admin_role' => 'Super Admin',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 10,
                'first_name' => 'John',
                'last_name' => 'Lloyd',
                'admin_role' => 'Super Admin',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 13,
                'first_name' => 'Brian',
                'last_name' => 'Monsales',
                'admin_role' => 'Admin',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 16,
                'first_name' => 'Vince',
                'last_name' => 'Gunday',
                'admin_role' => 'Admin',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
