<?php

namespace App\Http\Controllers;

use App\Mail\AlbumAccessMail;
use App\Models\Album;
use App\Models\Capture;
use App\Models\Photobooth;
use App\Models\Remote;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $venues = Venue::all();
        $photobooths = Photobooth::all();
        $albums = Album::all();
        $remotes = Remote::all();
        $users = User::all();
        $captures = Capture::all();

        // Get all album IDs with 'longterm' status
        $longtermAlbumIds = $albums->where('status', 'longterm')->pluck('id')->toArray();

        // Filter out users who are not linked to albums with 'longterm' status
        $liveUsers = User::whereNotIn('album_id', $longtermAlbumIds)->get();

        // Get the live albums
        $liveAlbums = Album::where('status', 'live')->pluck('id');

        // Fetch the original users (users with the smallest id for each album)
        $albumOwners = User::whereIn('album_id', $liveAlbums)
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MIN(id)'))
                    ->from('users')
                    ->groupBy('album_id');
            })
            ->get();

        //dd($albumOwners);

        // Get all remote IDs that are already linked to an album
        $linkedRemoteIds = $albums->whereNotNull('remote_id')->pluck('remote_id')->toArray();

        // Filter out remotes that are already linked to an album
        $availableRemotes = Remote::whereNotIn('id', $linkedRemoteIds)->get();

        return view('home', [
            'venues' => $venues,
            'remotes' => $remotes,
            'availableRemotes' => $availableRemotes,
            'liveUsers' => $liveUsers,
            'albumOwners' => $albumOwners,
            'photobooths' => $photobooths,
            'albums' => $albums,
            'users' => $users,
            'captures' => $captures,
            'noData' => $albums->isEmpty() && $users->isEmpty() && $captures->isEmpty(), // Check for empty data
        ]);
    }
}
