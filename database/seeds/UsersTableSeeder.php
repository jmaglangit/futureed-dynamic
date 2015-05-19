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
            'password' => sha1('Farrahdy1!'),
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
            'password' => sha1('farrahdy'),
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
            'password' => sha1('farrahdy'),
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
               'password' => sha1('johnreyq'),
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
               'password' => sha1('johnreyq'),
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
               'password' => sha1('johnreyq'),
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
               'password' => sha1('jasonmag'),
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
               'password' => sha1('jasonmag'),
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
               'password' => sha1('jasonmag'),
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
               'password' => sha1('jolliemar'),
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
               'password' => sha1('jolliemar'),
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
               'password' => sha1('jolliemar'),
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
               'password' => sha1('bmonsales'),
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
               'password' => sha1('bmonsales'),
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
               'password' => sha1('bmonsales'),
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
               'password' => sha1('vgunday'),
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
               'password' => sha1('vgunday'),
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
               'password' => sha1('vgunday'),
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