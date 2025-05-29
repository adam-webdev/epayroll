<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Buat role
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'karyawan']);

        // Buat user admin
        $tris = User::firstOrCreate(
            ['email' => 'adminsistem@gmail.com'],
            [
                'name' => 'admin sistem',
                'password' => Hash::make('admin123'), // default password: password
            ]
        );
        $tris->assignRole('admin');

        // Buat user admin
        $putri = User::firstOrCreate(
            ['email' => 'karyawan@gmail.com'],
            [
                'name' => 'Putri Sari',
                'password' => Hash::make('password'), // default password: password
            ]
        );
        $putri->assignRole('admin');
    }
}