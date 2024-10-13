<!-- resources/views/albums/show.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Album Details</title>
</head>
<body>
    <h1>Album Details</h1>
    <p><strong>ID:</strong> {{ $album->id }}</p>
    <p><strong>Remote ID:</strong> {{ $album->remote_id }}</p>
    <p><strong>Venue ID:</strong> {{ $album->venue_id }}</p>
    <p><strong>Status:</strong> {{ $album->status }}</p>
    <p><strong>Date Added:</strong> {{ $album->date_add }}</p>
    <p><strong>Date Over:</strong> {{ $album->date_over }}</p>
    <p><strong>Date Updated:</strong> {{ $album->date_upd }}</p>
</body>
</html>
