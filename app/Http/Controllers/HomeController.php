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

        // Get all remote IDs that are already linked to an album
        $linkedRemoteIds = $albums->whereNotNull('remote_id')->pluck('remote_id')->toArray();

        // Filter out remotes that are already linked to an album
        $availableRemotes = Remote::whereNotIn('id', $linkedRemoteIds)->get();

        return view('home', [
            'venues' => $venues,
            'remotes' => $remotes,
            'availableRemotes' => $availableRemotes,
            'liveUsers' => $liveUsers,
            'photobooths' => $photobooths,
            'albums' => $albums,
            'users' => $users,
            'captures' => $captures,
            'noData' => $albums->isEmpty() && $users->isEmpty() && $captures->isEmpty(), // Check for empty data
        ]);
    }

    public function create(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'remote_id' => 'required|exists:remotes,id',    // Ensure the remote_id exists in the remotes table
        ]);

        // Find the remote using the remote_id from the request
        $remote = $request->remote_id ? Remote::findOrFail($request->remote_id) : null;

        // Get the venue_id from the remote
        $venue_id = $remote->venue_id;

        // Create a new album with the remote_id, venue_id and status = 'live'
        $album = Album::create([
            'remote_id' => $remote ? $remote->id : null,
            'venue_id' => $venue_id,
            'status' => 'live',
        ]);

        // Create a new user with the name, email, and album_id
        $user =User::create([
            'name' => $request->name,
            'email' => $request->email,
            'album_id' => $album->id,   // Link the user to the album
        ]);

        // Generate the token using salt + user_id + album_id
        $salt = env('SALT');
        $tokenString = $salt . $user->id . $album->id;
        $token = Hash::make($tokenString);

        // Optionally, store the token in a cookie for later use
        $cookie = cookie('access_token', $token, 60 * 24 * 30); // Expires in 30 days
        Cookie::queue($cookie);

        // Generate the URL with the token
        $albumUrl = url("photographer/album/{$album->id}/user/{$user->id}/{$token}");

        // Send and email to the user with the album URL
        Mail::to($user->email)->send(new AlbumAccessMail($albumUrl, $user));

        return redirect()->route('home')->with('success', 'Album and user created successfully!');
    }

    public function createCaptures(Request $request)
    {
        // Validate the request data
        $request->validate([
            'images.*' => 'required|file|image|mimes:png,jpg,webp|max:20240',
            'album_id' => 'required|exists:albums,id',
        ]);

        $paths = [];

        // Check if the request contains multiple files
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $paths[] = Storage::disk('public')->put('/captures', $file);
            }
        }

        // Save each file path to the database
        foreach ($paths as $path) {
            Capture::create([
                'album_id' => $request->album_id,
                'image' => $path,
            ]);
        }

        // Find the album and update the date_up column
        $album = Album::find($request->album_id);
        if ($album) {
            $album->update(['date_upd' => now()]);
        }
        
        return redirect()->route('home')->with('success', 'Capture created successfully!');
    }
}
