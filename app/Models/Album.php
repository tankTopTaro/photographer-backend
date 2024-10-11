<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'remote_id', 
        'venue_id', 
        'date_add', 
        'date_over', 
        'date_upd', 
        'status'
    ];

    public function remote() {
        return $this->belongsTo(Remote::class);
    }

    public function venue() {
        return $this->belongsTo(Venue::class);
    }

    public function captures() {
        return $this->hasMany(Capture::class);
    }

    public function users() {
        return $this->belongsToMany(User::class)->withPivot('hash')->withTimestamps();
    }
}
