<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_name',
        'region_name',
        'region_level',
        'tagline',
        'logo_path',
        'image_umkm',
        'image_pariwisata',
        'image_festival',
        'updated_by'
    ];

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
