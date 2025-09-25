<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('app.categories') }} {{request()->input('archived') == 'true' ? '(' . __('app.archived') . ')' : ''}}
        </h2>
    </x-slot>

    @if(request()->input('archived') == 'true')
        {{-- archived categories --}}


        <div class="flex justify-end max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <a href="{{ route('categories.index') }}"
                class="px-4 py-2 text-white text-sm font-medium rounded-lg shadow 
                                                                      bg-gradient-to-r from-green-500 to-green-700
                                                                      hover:from-green-600 hover:to-green-800
                                                                      transition duration-300 ease-in-out transform hover:scale-105">
                {{ __('app.active_categories') }}
            </a>
        </div>

    @else
        {{-- active categories buton --}}
        <div class="flex justify-end max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <a href="{{ route('categories.index', ['archived' => 'true']) }}"
                class="px-4 py-2 text-white text-sm font-medium rounded-lg shadow 
                                                                      bg-gradient-to-r from-gray-500 to-gray-700
                                                                      hover:from-gray-600 hover:to-gray-800
                                                                      transition duration-300 ease-in-out transform hover:scale-105">
                {{ __('app.archived_categories') }}
            </a>
        </div>
    @endif










    <div class="flex justify-end max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <a href="{{ route('categories.create') }}" class="px-4 py-2 text-white text-sm font-medium rounded-lg shadow 
              bg-gradient-to-r from-indigo-500 to-purple-500
              hover:from-indigo-600 hover:to-purple-600
              transition duration-300 ease-in-out transform hover:scale-105">
            + {{ __('app.new_job_category') }}
        </a>
    </div>



    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <table class="w-full border-collapse border border-gray-200 rounded-lg overflow-hidden shadow">
                    <thead class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white">
                        <tr>
                            <th class="px-6 py-3 text-start text-sm font-semibold">#</th>
                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.category_name') }}</th>
                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $category->name }}</td>

                                @if(request()->input('archived') == 'true')
                                    <td class="px-6 py-4 text-sm">
                                        <form action="{{ route('categories.restore', $category->id) }}" method="POST"
                                            onsubmit="return confirm('{{ __('app.restore_category') }}')">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-500 text-white text-xs rounded-lg shadow hover:bg-green-600 transition">
                                                {{ __('common.restore') }}
                                            </button>
                                        </form>
                                    </td>
                                @else

                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex gap-2 rtl:flex-row-reverse">
                                                <a href="{{route('categories.edit', $category->id)}}"
                                                    class="px-3 py-1 bg-blue-500 text-white text-xs rounded-lg shadow hover:bg-blue-600 transition">
                                                    {{ __('common.edit') }}
                                                </a>
                                                <form action="{{route("categories.destroy", $category->id)}}" method="POST"
                                                    onsubmit="return confirm('{{ __('common.are_you_sure') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-3 py-1 bg-red-500 text-white text-xs rounded-lg shadow hover:bg-red-600 transition">
                                                        {{ __('common.archive') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                    {{ __('app.no_categories_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $categories->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>