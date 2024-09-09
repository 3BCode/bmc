<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonorDarah extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_kegiatan',
        'deskripsi_kegiatan',
        'lokasi_kegiatan',
        'tanggal_kegiatan',
        'waktu_mulai',
        'waktu_selesai',
        'jumlah_pendaftar',
        'kebutuhan_darah',
        'golongan_darah',
        'notifikasi_pengingat',
    ];
}
