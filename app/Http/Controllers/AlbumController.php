<?php

namespace App\Http\Controllers;

use App\Mail\AlbumAccessMail;
use App\Models\Album;
use App\Models\Remote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AlbumController extends Controller
{
    public function create(Request $request) {
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

        // Generate a token for the user
        $salt = env('SALT');
        $tokenString = $salt . $album->id . $user->id;
        $token = hash('sha256', $tokenString);

        // Generate the album access link
        $albumUrl = route('album', ['albumId' => $album->id, 'userId' => $user->id, 'token' => $token]);

        // Send an email to the user with the album access link
        Mail::to($user->email)->send(new AlbumAccessMail($albumUrl, $token ,$user));

        return redirect()->route('home')->with('success', 'Album and user created successfully!');
    }

    public function show ($albumId, $userId, $token) {

        // Find the album and user by their IDs
        $album = Album::findOrFail($albumId);
        $user = User::findOrFail($userId);

        // Generate a token for the user
        $salt = env('SALT');
        $expectedTokenString = $salt . $album->id . $user->id;
        $expectedToken = hash('sha256', $expectedTokenString);
        $isValid = $expectedToken === $token;

        if ($isValid) {
            return view('album', [
                'album' => $album,
                'user' => $user,
            ]);
        } else {
            return redirect()->route('home')->with('error', 'Invalid token. Please try again.');
        }
    }

    public function inviteUser (Request $request) {
        $request->validate([
            'album_id' => 'required|exists:albums,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Find the album using the album_id from the request
        $album = Album::findOrFail($request->album_id);

        // Create a new user with the name, email, and album_id
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'album_id' => $album->id,   // Link the user to the album
        ]);

        // Generate a token for the user
        $salt = env('SALT');
        $tokenString = $salt . $album->id . $user->id;
        $token = hash('sha256', $tokenString);

        // Generate the album access link
        $albumUrl = route('album', ['albumId' => $album->id, 'userId' => $user->id, 'token' => $token]);

        // Send an email to the user with the album access link
        Mail::to($user->email)->send(new AlbumAccessMail($albumUrl, $token ,$user));

        return redirect()->route('home')->with('success', 'User invited successfully!');

    }

    // Update the album status, date_over, remote_id
    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'album_id' => 'required|exists:albums,id',
            'status' => 'required|in:live,longterm',
        ]);

        // Find the album using the album_id from the request
        $album = Album::find($request->album_id);

        // Check if status is changing from "live" to "longterm"
        if($album->status === 'live' && $request->status === 'longterm' && $album->remote_id && $album->venue_id) {
            $album->date_over = now();
            $album->remote_id = null; // Only de-associate if there is an associated remote
        }

        // Update the album status
        $album->status = $request->status;

        // Save the album
        $album->save();

        // Send email to all users connected to this album
        if($request->status === 'longterm') {   // Only send email if status is longterm
            $users = User::where('album_id', $album->id)->get();    // Get all users connected to this album

            // Loop through each user and send an email
            foreach ($users as $user) {
                // Generate a token for the user
                $salt = env('SALT');
                $tokenString = $salt . $album->id . $user->id;
                $token = hash('sha256', $tokenString);

                // Generate the album access link
                $albumUrl = route('album', ['albumId' => $album->id, 'userId' => $user->id, 'token' => $token]);

                // Send an email to the user with the album access link
                Mail::to($user->email)->send(new AlbumAccessMail($albumUrl, $token ,$user));
            }
        }

        return redirect()->route('home')->with('success', 'Album status updated successfully!');
    }
}
