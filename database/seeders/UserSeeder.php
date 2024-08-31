<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Siswa;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder Untuk Membuat Akun Admin
        $admin = Role::where('name','admin')->first();

        User::create([
            'role_id' => $admin->id,
            'uuid' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('123'),
        ]);
        $siswa = Role::where('name','siswa')->first();

        $data = User::create([
            'role_id' => $siswa->id,
            'uuid' => '3202116021',
            'name' => 'Hafiz Putra Pratama',
            'email' => 'hafiz@email.com',
            'password' => bcrypt('123'),
        ]);

        Siswa::create([
            'user_id' => $data->id,
            'phone' => '6285157267750',
            'address' => 'Jl Tanjung Raya 2',
        ]);
    }
}
