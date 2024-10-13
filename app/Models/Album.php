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

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($album) {
            if ($album->status === 'longterm' && $album->getOriginal('status') === 'live') {
                // Set the remote_id to null automatically
                $album->remote_id = null;
            }
        });
    }

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
