<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicService extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_agreed' => 'boolean',
        'handled_at' => 'datetime',
        'ready_at' => 'datetime',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function attachments()
    {
        return $this->hasMany(PublicServiceAttachment::class, 'public_service_id');
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}
