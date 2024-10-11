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
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="fixed top-0 right-0 m-4 p-4 bg-green-500 text-white rounded">
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

<div x-show="activeTable === 'create'" x-transition class="flex flex-col w-full">
    <h1 class="text-2xl font-bold text-center mb-8">Create Album & User</h1>

    <form action="{{ route('create')}}" method="post">
        @csrf

        <label for="name" class="block text-sm font-medium text-gray-700 mt-4">Name</label>
        <input type="text" name="name" id="name" class="mt-1 block w-full p-2 border border-gray-300 rounded">

        <label for="email" class="block text-sm font-medium text-gray-700 mt-4">Email</label>
        <input type="text" name="email" id="email" class="mt-1 block w-full p-2 border border-gray-300 rounded">

        <label for="remoteSelector" class="block text-sm font-medium text-gray-700 mt-4">Select Remote</label>
            <select id="remoteSelector" name="remote_id" x-model="selectedRemote" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                <option value="">Select a Remote</option>
                @foreach ($remotes as $remote)
                    <option value="{{ $remote->id }}">Remote {{ $remote->id }}</option>
                @endforeach
            </select>

            <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
    </form>
</div>

<div x-show="activeTable === 'capture'" x-transition class="flex flex-col w-full">
    <h1 class="text-2xl font-bold text-center mb-8">Create Captures</h1>

    <form action="{{ route('create-captures')}}" method="post" enctype="multipart/form-data">
        @csrf

        <label for="userSelector" class="block text-sm font-medium text-gray-700 mt-4">Select User</label>
        <select id="userSelector" name="album_id" x-model="selectedUser" class="mt-1 block w-full p-2 border border-gray-300 rounded">
            <option value="">Select User</option>
            @foreach ($users as $user)
                <option value="{{ $user->album_id }}">{{ $user->name }}</option>
            @endforeach
        </select>


        <label for="image" class="block text-sm font-medium text-gray-700 mt-4">Upload Image</label>
        <div class="mt-1" x-data="{ fileName: 'No file chosen' }">
            <input type="file" name="image" id="image" class="hidden" @change="fileName = $event.target.files[0] ? $event.target.files[0].name : 'No file chosen'" />
            <label for="image" class="flex items-center justify-center px-4 py-2 bg-blue-500 text-white font-bold rounded cursor-pointer hover:bg-blue-700 transition">
                Choose File
            </label>
            <span class="mt-2 text-sm text-gray-600" x-text="fileName"></span>
        </div>

        <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
    </form>
</div>
@endsection