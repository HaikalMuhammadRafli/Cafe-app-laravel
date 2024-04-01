<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = '450';
        $input['nama_user'] = 'Pelanggan';
        $input['email'] = 'pelanggan@email.com';
        $input['password'] = Hash::make($password);
        $input['id_level'] = 1;
        User::create($input);

        $input1['nama_user'] = 'Kasir';
        $input1['email'] = 'kasir@email.com';
        $input1['password'] = Hash::make($password);
        $input1['id_level'] = 2;
        User::create($input1);

        $input2['nama_user'] = 'Admin';
        $input2['email'] = 'admin@email.com';
        $input2['password'] = Hash::make($password);
        $input2['id_level'] = 3;
        User::create($input2);
    }
}
