<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body  x-data="{ activeTable: null, noData: {{ $noData ? 'true' : 'false' }} }">
  @include('components.navbar')
    <main class="w-screen px-16 overflow-hidden">
        @yield('content')
    </main>
</body>
</html>