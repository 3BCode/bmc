<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZakatInfaq extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'gambar_qris',
        'deskripsi',
        'isi',
    ];
}
