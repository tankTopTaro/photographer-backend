<div class="flex flex-col w-full">
    <h1 class="text-2xl font-bold text-center mb-8">{{ $tableName ?? 'Data' }} Table</h1>
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr>
                @foreach ($columns as $column)
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                  {{ $column }}
                </th>
                @endforeach
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @foreach ($table as $item)
                <tr>
                    @foreach ($columns as $column)
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            @if ($tableName === 'Albums' && $column === 'status')
                              <form action="{{ route('album-status') }}" method="post">
                                  @csrf
                                  <input type="hidden" name="album_id" value="{{ $item->id }}">

                                  <select name="status" onchange="this.form.submit()" class="mt-1 block p-2 border border-gray-300" {{ $item->status === 'longterm' ? 'disabled' : '' }}>
                                      <option value="live" {{ $item->status == 'live' ? 'selected' : '' }}>Live</option>
                                      <option value="longterm" {{ $item->status == 'longterm' ? 'selected' : '' }}>Long Term</option>
                                  </select>
                              </form>
                            @else
                              {{ $item->$column }}
                            @endif
                        </td>
                    @endforeach
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>