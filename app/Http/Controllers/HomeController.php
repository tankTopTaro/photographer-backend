<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Capture;
use App\Models\Photobooth;
use App\Models\Remote;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $venues = Venue::all();
        $photobooths = Photobooth::all();
        $remotes = Remote::all();
        $albums = Album::all();
        $users = User::all();
        $captures = Capture::all();

        return view('home', [
            'venues' => $venues,
            'remotes' => $remotes,
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
        $remote = Remote::findOrFail($request->remote_id);

        // Get the venue_id from the remote
        $venue_id = $remote->venue_id;

        // Create a new album with the remote_id, venue_id and status = 'live'
        $album = Album::create([
            'remote_id' => $remote->id,
            'venue_id' => $venue_id,
            'status' => 'live',
        ]);

        // Create a new user with the name, email, and album_id
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'album_id' => $album->id,   // Link the user to the album
        ]);

        return redirect()->route('home')->with('success', 'Album and user created successfully!');
    }

    public function createCaptures(Request $request)
    {
        // Validate the request data
        $request->validate([
            'image' => 'file|image|nullable|mimes:png,jpg,webp|max:20240',
            'album_id' => 'required|exists:albums,id',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = Storage::disk('public')->put('/captures', $request->image);
        }

        $capture = Capture::create([
            'album_id' => $request->album_id,
            'image' => $path,
        ]);
        
        return redirect()->route('home')->with('success', 'Capture created successfully!');
    }
}
