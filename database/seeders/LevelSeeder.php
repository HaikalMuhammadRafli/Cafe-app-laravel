<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input['nama_level'] = 'Pelanggan';
        Level::create($input);

        $input1['nama_level'] = 'Kasir';
        Level::create($input1);

        $input2['nama_level'] = 'Admin';
        Level::create($input2);
    }
}
