<div x-show="activeTable === 'capture'" x-transition class="flex flex-col w-full">
    <h1 class="text-2xl font-bold text-center mb-8">Create Captures</h1>

    <form action="{{ route('create-captures')}}" method="post" enctype="multipart/form-data">
        @csrf

        <label for="userSelector" class="block text-sm font-medium text-gray-700 mt-4">Select User</label>
        <select id="userSelector" name="album_id" x-model="selectedUser" class="mt-1 block w-full p-2 border border-gray-300 rounded">
            <option value="">Select User</option>
            @foreach ($albumOwners as $user)
                <option value="{{ $user->album_id }}">{{ $user->name }}</option>
            @endforeach
        </select>


        <label for="images" class="block text-sm font-medium text-gray-700 mt-4">Upload Image</label>
        <div class="mt-1" x-data="{ fileName: 'No file chosen' }">
            <input type="file" name="images[]" id="images" class="hidden" multiple @change="fileName = $event.target.files.length ? Array.from($event.target.files).map(file => file.name).join(', ') : 'No files chosen'" />
            <label for="images" class="flex items-center justify-center px-4 py-2 bg-blue-500 text-white font-bold rounded cursor-pointer hover:bg-blue-700 transition">
                Choose File
            </label>
            <span class="mt-2 text-sm text-gray-600" x-text="fileName"></span>
        </div>

        <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
    </form>
</div>