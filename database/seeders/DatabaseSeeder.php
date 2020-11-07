<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $user = new User();
        $user->name = "Super";
        $user->lastname = "Admin";
        $user->email = "admin@admin.com";
        $user->password = Hash::make("12345678");
        $user->role = 2;
        $user->save();
    }
}
