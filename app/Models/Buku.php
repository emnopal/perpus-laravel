<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'judul',
        'isbn',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'jumlah_buku',
        'deskripsi',
        'cover'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
