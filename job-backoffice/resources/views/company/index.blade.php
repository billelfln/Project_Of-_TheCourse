<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('app.companies') }} {{ request()->input('archived') == 'true' ? '(' . __('app.archived') . ')' : '' }}
        </h2>
    </x-slot>

    {{-- زر التبديل بين active و archived --}}
    @if(request()->input('archived') == 'true')
        <div class="flex justify-end max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <a href="{{ route('companies.index', ['archived' => 'false']) }}" class="px-4 py-2 text-white text-sm font-medium rounded-lg shadow
                              bg-gradient-to-r from-green-500 to-green-700
                              hover:from-green-600 hover:to-green-800
                              transition duration-300 ease-in-out transform hover:scale-105">
                {{ __('app.active_companies') }}
            </a>
        </div>
    @else
        <div class="flex justify-end max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <a href="{{ route('companies.index', ['archived' => 'true']) }}" class="px-4 py-2 text-white text-sm font-medium rounded-lg shadow
                              bg-gradient-to-r from-gray-500 to-gray-700
                              hover:from-gray-600 hover:to-gray-800
                              transition duration-300 ease-in-out transform hover:scale-105">
                {{ __('app.archived_companies') }}
            </a>
        </div>
    @endif


    {{-- زر إضافة كومبني جديد --}}
    <div class="flex justify-end max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <a href="{{ route('companies.create') }}" class="px-4 py-2 text-white text-sm font-medium rounded-lg shadow 
                  bg-gradient-to-r from-indigo-500 to-purple-500
                  hover:from-indigo-600 hover:to-purple-600
                  transition duration-300 ease-in-out transform hover:scale-105">
            + {{ __('app.new_company') }}
        </a>
    </div>

    {{-- جدول عرض الشركات --}}
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <table class="w-full border-collapse border border-gray-200 rounded-lg overflow-hidden shadow">
                    <thead class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white">
                        <tr>
                            <th class="px-6 py-3 text-start text-sm font-semibold">#</th>
                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.company_name') }}</th>
                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.address') }}</th>
                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.industry') }}</th>
                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.website') }}</th>


                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($companies as $company)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-indigo-600">
                                    <span>
                                        @if (request('archived') == 'false')
                                            <a href="{{ route('companies.show', $company->id) }}"
                                                class="text-blue-600 hover:underline">
                                                {{ $company->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-600">{{ $company->name }}</span>
                                        @endif
                                    </span>


                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $company->address }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $company->industry }}</td>
                                <td class="px-6 py-4 text-sm text-blue-600">
                                    <a href="{{ $company->website }}" target="_blank" class="hover:underline">
                                        {{ $company->website }}
                                    </a>
                                </td>


                                {{-- Actions --}}
                                <td class="px-6 py-4 text-sm">
                                    @if(request()->input('archived') == 'true')
                                        {{-- زر الاسترجاع --}}
                                        <form action="{{ route('companies.restore', $company->id) }}" method="POST"
                                            onsubmit="return confirm('{{ __('app.restore_company') }}')">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-500 text-white text-xs rounded-lg shadow hover:bg-green-600 transition">
                                                {{ __('common.restore') }}
                                            </button>
                                        </form>
                                    @else
                                        <div class="flex gap-2 rtl:flex-row-reverse">
                                            {{-- Edit --}}
                                            <a href="{{ route('companies.edit', [$company->id, 'redirectToList' => 'true']) }}"
                                                class="px-3 py-1 bg-blue-500 text-white text-xs rounded-lg shadow hover:bg-blue-600 transition">
                                                {{ __('common.edit') }}
                                            </a>
                                            {{-- Archive --}}
                                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST"
                                                onsubmit="return confirm('{{ __('common.are_you_sure') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-500 text-white text-xs rounded-lg shadow hover:bg-red-600 transition">
                                                    {{ __('common.archive') }}
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                    {{ __('app.no_companies_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}

                {{-- Laravel pagination links with query string appended
                Example: if the current URL is /jobs?category=IT&page=2
                → the "category=IT" part will stay in the URL while switching pages
                --}}


                <div class="mt-4">
                    {{ $companies->appends(request()->query())->links() }}
                </div>
                @if(session('success'))
                    <div id="success-message" class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let message = document.getElementById("success-message");
        if (message) {
            setTimeout(() => {
                message.style.transition = "opacity 1s ease";
                message.style.opacity = "0";
                setTimeout(() => message.remove(), 1000); // يحذف العنصر بعد الاختفاء
            }, 3000); // ⏳ يبقى 3 ثواني قبل ما يبدأ يختفي
        }
    });
</script>