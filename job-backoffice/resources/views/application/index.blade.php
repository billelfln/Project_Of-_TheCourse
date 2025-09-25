<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('app.job_applications') }}
            {{ request()->input('archived') == 'true' ? '(' . __('app.archived') . ')' : '' }}
        </h2>
    </x-slot>

    {{-- زر التبديل بين Active و Archived --}}
    <div class="flex justify-between max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        @if(request()->input('archived') == 'true')
            <a href="{{ route('job_applications.index', ['archived' => 'false']) }}"
                class="px-4 py-2 text-white text-sm font-medium rounded-lg shadow bg-green-600 hover:bg-green-700 transition">
                {{ __('app.active_applications') }}
            </a>
        @else
            <a href="{{ route('job_applications.index', ['archived' => 'true']) }}"
                class="px-4 py-2 text-white text-sm font-medium rounded-lg shadow bg-gray-600 hover:bg-gray-700 transition">
                {{ __('app.archived_applications') }}
            </a>
        @endif
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
                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.applicant') }}</th>
                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.position') }}</th>
                            @if(auth()->user()->role == 'admin')
                                <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.company') }}</th>
                            @endif
                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.status') }}</th>
                            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($applications as $application)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>

                                <td class="px-6 py-4 text-sm font-medium text-indigo-600">
                                    @if(request('archived') == 'false')
                                        <a href="{{ route('job_applications.show', $application->id) }}"
                                            class="hover:underline">
                                            {{$application->user?->name ?? '-' }}
                                        </a>
                                    @else
                                        <span class="text-gray-600">{{ $application->user?->name ?? '-' }}</span>
                                    @endif
                                </td>



                                {{-- Position title --}}
                                <td class="px-6 py-4 text-sm">
                                    {{ $application->jobVacancy?->title ?? '-' }}
                                </td>

                                @if(auth()->user()->role == 'admin')
                                    {{-- Company name --}}
                                    <td class="px-6 py-4 text-sm">
                                        {{ $application->jobVacancy?->company?->name ?? '-' }}
                                    </td>
                                @endif

                                {{-- Status --}}
                                <td class="px-6 py-4 text-sm font-semibold">
                                    @if ($application->status === 'pending')
                                        <span class="px-2 py-1 rounded-full text-yellow-700 bg-yellow-100">
                                            {{ __('app.pending') }}
                                        </span>
                                    @elseif ($application->status === 'accepted')
                                        <span class="px-2 py-1 rounded-full text-green-700 bg-green-100">
                                            {{ __('app.accepted') }}
                                        </span>
                                    @elseif ($application->status === 'rejected')
                                        <span class="px-2 py-1 rounded-full text-red-700 bg-red-100">
                                            {{ __('app.rejected') }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-gray-700 bg-gray-100">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    @endif
                                </td>


                                {{-- Actions --}}
                                <td class="px-6 py-4 text-sm">
                                    @if(request('archived') == 'true')
                                        <form action="{{ route('job_applications.restore', $application->id) }}" method="POST"
                                            onsubmit="return confirm('{{ __('app.restore_application') }}')">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                                {{ __('common.restore') }}
                                            </button>
                                        </form>
                                    @else
                                        <div class="flex gap-2 rtl:flex-row-reverse">
                                            <a href="{{ route('job_applications.edit', $application->id) }}"
                                                class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                                {{ __('common.edit') }}
                                            </a>
                                            <form action="{{ route('job_applications.destroy', $application->id) }}"
                                                method="POST" onsubmit="return confirm('{{ __('app.archive_application') }}')"
                                                @csrf @method('DELETE') <button type="submit"
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
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    {{ __('app.no_applications_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $applications->appends(request()->query())->links() }}
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