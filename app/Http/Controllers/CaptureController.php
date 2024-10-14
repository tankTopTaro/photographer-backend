<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Capture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CaptureController extends Controller
{
    public function create (Request $request)
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
