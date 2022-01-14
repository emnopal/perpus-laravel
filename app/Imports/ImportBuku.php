<?php

namespace App\Imports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportBuku implements ToModel, WithStartRow
{

    public function model(array $row)
    {
        return new Buku([
            'judul' => $row[0],
            'isbn' => $row[1],
            'pengarang' => $row[2],
            'penerbit' => $row[3],
            'tahun_terbit' => $row[4],
            'jumlah_buku' => $row[5],
            'deskripsi' => $row[6],
            'cover' => null,
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
