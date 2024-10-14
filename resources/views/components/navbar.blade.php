<header>
    <nav x-data="{ open: false }" class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
          <div class="relative flex h-16 items-center justify-between">
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
              <div class="flex flex-shrink-0 items-center">
                <h1 class="uppercase text-white font-semibold">Photographer Mission</h1>
              </div>
            </div>
            <div class="flex gap-4">
              <button @click="activeTable = activeTable === 'create' ? null : 'create'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Album & User</button>
              <button @click="activeTable = activeTable === 'add-user-to-album' ? null : 'add-user-to-album'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add User to Album</button>
              <button @click="activeTable = activeTable === 'capture' ? null : 'capture'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Captures</button>
            </div>
          </div>
        </div>
    </nav>
</header>