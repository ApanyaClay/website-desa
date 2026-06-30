<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_desa',
        'visi',
        'misi',
        'sejarah',
        'logo_path',
        'koordinat_peta',
        'google_maps_iframe',
        'email',
        'telepon',
        'alamat',
    ];
}
