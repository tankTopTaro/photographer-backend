<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function remote()
    {
        return $this->hasMany(Remote::class);
    }

    public function photobooth()
    {
        return $this->hasMany(Photobooth::class);
    }
}
