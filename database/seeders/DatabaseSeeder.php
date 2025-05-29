<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(UserSedeer::class);
    }
}
































  // $user = new \App\Models\User();
        // $user->name = 'Adminbmb';
        // $user->email = 'adminbmb@gmail.com';
        // $user->password = bcrypt('pwnyaapaemang00');
        // $user->save();