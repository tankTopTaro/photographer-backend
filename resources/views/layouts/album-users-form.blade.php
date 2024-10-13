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
            @foreach ($availableRemotes as $remote)
                <option value="{{ $remote->id }}">Remote {{ $remote->id }}</option>
            @endforeach
        </select>

        <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
    </form>
</div>