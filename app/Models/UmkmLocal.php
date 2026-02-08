<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmkmLocal extends Model
{
    use \App\Traits\Auditable;

    protected $fillable = [
        'name',
        'product',
        'price',
        'original_price',
        'description',
        'contact_wa',
        'image_path',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
    ];
}
