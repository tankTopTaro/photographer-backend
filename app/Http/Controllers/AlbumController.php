<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AlbumController extends Controller
{
    public function show ($albumId, $userId, $token) {
        // Find the album and user by id
        $album = Album::findOrFail($albumId); 
        $user = User::findOrFail($userId);

        
        // Regenerate the original token for comparison
        $salt = env('SALT');
        $originalTokenString = $salt . $user->id . $album->id;
        $isValid = Hash::check($originalTokenString, $token);

        // Check if the token is valid
        if ($isValid) {
            return view('album', ['album' => $album, 'user' => $user]);
        } else {
            return "Invalid Token";
        }
        
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
            $album->venue_id = null;
        }

        // Update the album status
        $album->status = $request->status;

        // Save the album
        $album->save();

        return redirect()->route('home')->with('success', 'Album status updated successfully!');
    }
}
