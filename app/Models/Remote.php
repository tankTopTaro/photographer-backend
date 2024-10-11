<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remote extends Model
{
    use HasFactory;

    protected $fillable = ['venue_id'];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }
}
