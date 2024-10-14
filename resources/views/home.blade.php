@extends('layouts.app')

@section('title', 'Photographer Mission')
    
@section('content')

<div class="container flex flex-1 gap-4 mx-4 mt-4 mb-8">
    <button @click="activeTable = activeTable === 'venues' ? null : 'venues'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Show Venues</button>
    <button @click="activeTable = activeTable === 'photobooths' ? null : 'photobooths'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Show Photobooths</button>
    <button @click="activeTable = activeTable === 'remotes' ? null : 'remotes'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Show Remotes</button>

    <button @click="activeTable = activeTable === 'albums' ? null : 'albums'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :disabled="noData" :class="{ 'opacity-50 cursor-not-allowed': noData }">Show Albums</button>
    <button @click="activeTable = activeTable === 'users' ? null : 'users'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :disabled="noData"  :class="{ 'opacity-50 cursor-not-allowed': noData }">Show Users</button>
    <button @click="activeTable = activeTable === 'captures' ? null : 'captures'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :disabled="noData"  :class="{ 'opacity-50 cursor-not-allowed': noData }">Show Captures</button>
</div>

@if (session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="fixed top-0 left-0 m-4 p-4 bg-green-500 text-white rounded">
    <x-flashMsg msg="{{ session('success') }}" />
</div>
@endif

<div x-data="{ showMessage: true }" x-init="setTimeout(() => showMessage = false, 4000)">
    @if ($noData)
        <div x-show="showMessage" class="fixed top-0 right-0 m-4 p-4 bg-yellow-500 text-white rounded">
            There are no data in Albums or Users!
        </div>
    @endif
</div>

<div x-show="activeTable === 'venues'" x-transition>
    <x-table :table="$venues" tableName="Venues" />
</div>
<div x-show="activeTable === 'photobooths'" x-transition>
    <x-table :table="$photobooths" tableName="Photobooths" />
</div>
<div x-show="activeTable === 'remotes'" x-transition>
    <x-table :table="$remotes" tableName="Remotes" />
</div>
<div x-show="activeTable === 'albums'" x-transition>
    <x-table :table="$albums" tableName="Albums" />
</div>
<div x-show="activeTable === 'users'" x-transition>
    <x-table :table="$users" tableName="Users" />
</div>
<div x-show="activeTable === 'captures'" x-transition>
    <x-table :table="$captures" tableName="Captures" />
</div>

@include('layouts.album-users-form')

@include('layouts.captures-form')

@include('layouts.add-user-to-album')

@endsection