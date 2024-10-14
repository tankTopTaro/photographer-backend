<div x-show="activeTable === 'add-user-to-album'" x-transition class="flex flex-col w-full">
    <h1 class="text-2xl font-bold text-center mb-8">Add User to Album</h1>

    <form action="{{ route('invite-user') }}" method="post">
        @csrf

        <label for="userSelector" class="block text-sm font-medium text-gray-700 mt-4">Select User</label>
        <select id="userSelector" name="album_id" x-model="selectedUser" class="mt-1 block w-full p-2 border border-gray-300 rounded">
            <option value="">Select User</option>
            @foreach ($albumOwners as $user)
                <option value="{{ $user->album_id }}">{{ $user->name }}</option>
            @endforeach
        </select>

        <label for="name" class="block text-sm font-medium text-gray-700 mt-4">Name</label>
        <input type="text" name="name" id="name" class="mt-1 block w-full p-2 border border-gray-300 rounded">

        <label for="email" class="block text-sm font-medium text-gray-700 mt-4">Email</label>
        <input type="text" name="email" id="email" class="mt-1 block w-full p-2 border border-gray-300 rounded">

        <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
    </form>
</div>