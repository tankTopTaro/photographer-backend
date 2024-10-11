<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'album_id',
        'log',
        'date_add',
    ];

    protected $casts = [
        'date_add' => 'datetime',
    ];

    public function albums() {
        return $this->belongsToMany(Album::class)->withPivot('hash')->withTimestamps();
    }
}
