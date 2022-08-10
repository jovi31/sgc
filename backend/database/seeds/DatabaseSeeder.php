<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@mail.com';
        $user->password = Hash::make('123456');
        $user->admin = true;
        $user->save();
    }
}
