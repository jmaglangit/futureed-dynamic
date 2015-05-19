<?php

use FutureEd\Models\Core\User;
use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class UsersTableSeeder extends Seeder {


    public function run()
    {

        \DB::table('users')->truncate();
        \DB::table('users')->insert(
       [
            [
            'username' => 'farrahdy',
            'email' => 'fdy@nerubia.com',
            'password' => sha1('F5rr5hdy!'), //F5rr5hdy!
            'name' => 'Farrah Dy',
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
            [
            'username' => 'farrahdy',
            'email' => 'fdy@nerubia.com',
            'password' => sha1('F5rr5hdy!'), //F5rr5hdy!
            'name' => 'Farrah Dy',
            'user_type' => 'Client',
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
            [
            'username' => 'farrahdy',
            'email' => 'fdy@nerubia.com',
            'password' => sha1('F5rr5hdy!'), //F5rr5hdy!
            'name' => 'Farrah Dy',
            'user_type' => 'Student',
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
           [
               'username' => 'johnreyq',
               'email' => 'jquiros@nerubia.com',
               'password' => sha1('J0hnr3yq!'), //J0hnr3yq!
               'name' => 'John Rey',
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
            [
               'username' => 'johnreyq',
               'email' => 'jquiros@nerubia.com',
               'password' => sha1('J0hnr3yq!'), //J0hnr3yq!
               'name' => 'John Rey',
               'user_type' => 'Client',
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
           [
               'username' => 'johnreyq',
               'email' => 'jquiros@nerubia.com',
               'password' => sha1('J0hnr3yq!'), //J0hnr3yq!
               'name' => 'John Rey',
               'user_type' => 'Student',
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
           [
               'username' => 'jasonmag',
               'email' => 'jmaglangit@nerubia.com',
               'password' => sha1('J4s0nM4g!'), //J4s0nM4g!
               'name' => 'Jason Maglangit',
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
           [
               'username' => 'jasonmag',
               'email' => 'jmaglangit@nerubia.com',
               'password' => sha1('J4s0nM4g!'), //J4s0nM4g!
               'name' => 'Jason Maglangit',
               'user_type' => 'Client',
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
           [
               'username' => 'jasonmag',
               'email' => 'jmaglangit@nerubia.com',
               'password' => sha1('J4s0nM4g!'), //J4s0nM4g!
               'name' => 'Jason Maglangit',
               'user_type' => 'Student',
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
           [
               'username' => 'jolliemar',
               'email' => 'jgutang@nerubia.com',
               'password' => sha1('J0ll13m5r!'), //J0ll13m5r!
               'name' => 'Jason Maglangit',
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
           [
               'username' => 'jolliemar',
               'email' => 'jgutang@nerubia.com',
               'password' => sha1('J0ll13m5r!'), //J0ll13m5r!
               'name' => 'Jason Maglangit',
               'user_type' => 'Client',
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
           [
               'username' => 'jolliemar',
               'email' => 'jgutang@nerubia.com',
               'password' => sha1('J0ll13m5r!'), //J0ll13m5r!
               'name' => 'Jason Maglangit',
               'user_type' => 'Student',
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
           [
               'username' => 'bmonsales',
               'email' => 'bmonsales@nerubia.com',
               'password' => sha1('bM0ns5l3s!'), //bM0ns5l3s!
               'name' => 'Brian Monsales',
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
           [
               'username' => 'bmonsales',
               'email' => 'bmonsales@nerubia.com',
               'password' => sha1('bM0ns5l3s!'), //bM0ns5l3s!
               'name' => 'Brian Monsales',
               'user_type' => 'Client',
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
           [
               'username' => 'bmonsales',
               'email' => 'bmonsales@nerubia.com',
               'password' => sha1('bM0ns5l3s!'), //bM0ns5l3s!
               'name' => 'Brian Monsales',
               'user_type' => 'Student',
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
           [
               'username' => 'vgunday',
               'email' => 'vgunday@nerubia.com',
               'password' => sha1('vGund5y!'), //vGund5y!
               'name' => 'Vince Gunday',
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
           [
               'username' => 'vgunday',
               'email' => 'vgunday@nerubia.com',
               'password' => sha1('vGund5y!'), //vGund5y!
               'name' => 'Vince Gunday',
               'user_type' => 'Client',
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
           [
               'username' => 'vgunday',
               'email' => 'vgunday@nerubia.com',
               'password' => sha1('vGund5y!'), //vGund5y!
               'name' => 'Vince Gunday',
               'user_type' => 'Student',
               'login_attempt' => 0,
               'is_account_activated' => 1,
               'is_account_locked' => 0,
               'is_account_deleted' => 0,
               'status' => 'Enabled',
               'created_by' => 1,
               'updated_by' => 1,
               'created_at' => date("Y-m-d H:i:s"),
               'updated_at' => date("Y-m-d H:i:s")
           ]

        ]);



    }

}