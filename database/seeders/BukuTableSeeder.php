<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Buku::insert([
            [
                'judul' => 'Belajar Pemrograman Java',
                'isbn' => '9920392749',
                'pengarang' => 'Abdul Kadir',
                'penerbit' => 'PT. Restu Ibu',
                'tahun_terbit' => 2018,
                'jumlah_buku' => 20,
                'deskripsi' => 'Buku Pertama Belajar Pemrograman Java Utk Pemula',
                'cover' => 'buku_java.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Pemrograman Android',
                'isbn' => '9920395559',
                'pengarang' => 'Muhammad Nurhidayat',
                'penerbit' => 'PT. Restu Guru',
                'tahun_terbit' => 2018,
                'jumlah_buku' => 14,
                'deskripsi' => 'Jurus Rahasia Menguasai Pemrograman Android',
                'cover' => 'jurus_rahasia.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Android Application',
                'isbn' => '9920392000',
                'pengarang' => 'Dina Aulia',
                'penerbit' => 'PT. Restu Ayah',
                'tahun_terbit' => 2018,
                'jumlah_buku' => 5,
                'deskripsi' => 'Buku Pertama Belajar Pemrograman Java Utk Pemula',
                'cover' => 'create_your.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
