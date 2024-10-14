<!DOCTYPE html>
<html>
<head>
    <title>Album Captures</title>
</head>
<body>
    <h1>Album: {{ $album->id }} for {{ $user->name }}</h1>

    <div>
        <h2>Captured Images</h2>
        @if ($captures->isEmpty())
            <p>No captures available for this album.</p>
        @else
            @foreach ($captures as $capture)
                <img src="{{ asset('storage/' . $capture->image) }}" alt="Capture Image" style="width: 200px; height: auto;">
                <p>Captured at: {{ $capture->date_add }}</p>
            @endforeach
        @endif
    </div>
</body>
</html>
