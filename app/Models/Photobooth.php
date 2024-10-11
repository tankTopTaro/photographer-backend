<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photobooth extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_id',
        'name',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
