<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Seeder;

class AnggotaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Anggota::insert([
            [
                'id_anggota' => 1,
                'nama' => 'Admin001',
                'alamat' => 'Jl. Kebon Jeruk',
                'telp' => '0812341234',
                'email' => 'admin001@mail.com',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_anggota' => 2,
                'nama' => 'Users001',
                'alamat' => 'Jl. Kebon Jeruk',
                'telp' => '0812341234',
                'email' => 'user002@mail.com',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
