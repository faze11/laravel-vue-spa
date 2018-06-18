<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'email' => 'admin@test.com',
            'name' => 'Super Admin',
            'password' => bcrypt('qweqwe'),
        ]);
    }
}
