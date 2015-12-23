<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DefaultUserTableSeeder extends Seeder
{
    public function run()
    {
        //append default users
//        DB::table('users')->truncate();
        DB::table('users')->insert([
            [
                'username' => 'administrator',
                'email' => 'futureedlesson@gmail.com',
                'password' => sha1('FutureEd1'), //FutureEd1
                'name' => 'Admin',
                'user_type' => 'Admin',
                'login_attempt' => 0,
                'is_account_activated' => 1,
                'is_account_locked' => 0,
                'is_account_deleted' => 0,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
        ]);

        //append default admin
        DB::table('admins')->truncate();
        DB::table('admins')->insert([
            [
                'user_id' => 1,
                'first_name' => 'FutureEd',
                'last_name' => 'Admin',
                'admin_role' => 'Super Admin',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
