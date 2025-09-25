<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('app.job_vacancies') }}
            {{ request()->input('archived') == 'true' ? '(' . __('app.archived') . ')' : '' }}
        </h2>
    </x-slot>

    {{-- Toggle buttons between Active and Archived --}}
    <div class="flex justify-between max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        @if(request()->input('archived') == 'true')
            <a href="{{ route('jobVacancies.index', ['archived' => 'false']) }}"
                class="px-4 py-2 text-white text-sm font-medium rounded-lg shadow bg-green-600 hover:bg-green-700 transition">
                {{ __('app.active_vacancies') }}
            </a>
        @else
            <a href="{{ route('jobVacancies.index', ['archived' => 'true']) }}"
                class="px-4 py-2 text-white text-sm font-medium rounded-lg shadow bg-gray-600 hover:bg-gray-700 transition">
                {{ __('app.archived_vacancies') }}
            </a>
        @endif

        <a href="{{ route('jobVacancies.create') }}"
            class="px-4 py-2 text-white text-sm font-medium rounded-lg shadow bg-indigo-600 hover:bg-indigo-700 transition">
            + {{ __('app.new_vacancy') }}
        </a>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                {{-- Success Message --}}
                @if(session('success'))
                    <div id="success-message" class="mb-4 px-4 py-2 rounded bg-green-500 text-white">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Table --}}
                <table class="w-full border-collapse border border-gray-200 rounded-lg shadow">
                    <thead class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white">
                        <tr>
                            <th class="px-6 py-3 text-start text-sm font-semibold">#</th>
                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('common.title') }}</th>
                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.location') }}</th>
                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.salary') }}</th>
                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.type') }}</th>
                            @if(auth()->user()->role == 'admin')
                                <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.company') }}</th>
                            @endif
                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.category') }}</th>

                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($jobVacancies as $vacancy)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-indigo-600">
                                    @if(request('archived') == 'false')
                                        <a href="{{ route('jobVacancies.show', $vacancy->id) }}" class="hover:underline">
                                            {{ $vacancy->title }}
                                        </a>
                                    @else
                                        <span class="text-gray-600">{{ $vacancy->title }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $vacancy->location }}</td>
                                <td class="px-6 py-4 text-sm">${{number_format($vacancy->salary, 2)}}</td>
                                <td class="px-6 py-4 text-sm">{{ $vacancy->type }}</td>
                                @if(auth()->user()->role == 'admin')
                                    <td class="px-6 py-4 text-sm">{{ $vacancy->company?->name ?? '-' }}</td>
                                @endif
                                <td class="px-6 py-4 text-sm">{{ $vacancy->category->name }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if(request('archived') == 'true')
                                        <form action="{{ route('jobVacancies.restore', $vacancy->id) }}" method="POST"
                                            onsubmit="return confirm('{{ __('app.restore_this_vacancy') }}')">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                                {{ __('common.restore') }}
                                            </button>
                                        </form>
                                    @else
                                        <div class="flex gap-2 rtl:flex-row-reverse">
                                            <a href="{{ route('jobVacancies.edit', [$vacancy->id, 'redirectToList' => 'true']) }}"
                                                class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                                {{ __('common.edit') }}
                                            </a>
                                            <form action="{{ route('jobVacancies.destroy', $vacancy->id) }}" method="POST"
                                                onsubmit="return confirm('{{ __('common.are_you_sure') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                                    {{ __('common.archive') }}
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    {{ __('app.no_job_vacancies_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Laravel pagination links with query string appended
                Example: if the current URL is /jobs?category=IT&page=2
                → the "category=IT" part will stay in the URL while switching pages
                --}}

                <div class="mt-4">
                    {{ $jobVacancies->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        let message = document.getElementById("success-message");
        if (message) {
            setTimeout(() => {
                message.style.transition = "opacity 1s ease";
                message.style.opacity = "0";
                setTimeout(() => message.remove(), 1000);
            }, 3000);
        }
    });
</script>