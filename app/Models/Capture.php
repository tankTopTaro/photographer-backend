<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capture extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id',
        'image',
        'date_add',
    ];

    protected $casts = [
        'date_add' => 'datetime',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
