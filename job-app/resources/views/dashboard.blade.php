<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-black overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-white">
                    <h3 class="text-white text-2xl font-bold">{{ __('Welcome back,') }} {{ Auth::user()->name }}</h3>

                    {{-- Search & filters --}}
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mt-4 gap-4">
                        {{-- Search bar --}}
                        <form method="GET" action="{{ route('dashboard') }}" class="w-full md:max-w-md">
                            <div class="flex items-center border-b border-b-2 border-teal-500 py-2">
                                <input
                                    class="appearance-none bg-transparent border-none w-full text-white mr-3 py-1 px-2 leading-tight focus:outline-none"
                                    type="text" placeholder="Search jobs..." aria-label="Search" name="search"
                                    value="{{ request('search') }}">
                                <button type="submit"
                                    class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded">
                                    Search
                                </button>
                                @if (request('filter'))
                                    <input type="hidden" name="filter" value="{{ request('filter') }}">
                                @endif

                            </div>
                        </form>

                        {{-- Filters --}}
                        <div class="flex flex-wrap gap-2 mt-2 md:mt-0">
                            <a href="{{ route('dashboard', array_merge(request()->all(), ['filter' => 'Full-Time', 'search' => request('search')])) }}"
                                class="bg-gray-800 text-white px-3 py-1 rounded-full {{ request('filter') == 'Full-Time' ? 'bg-teal-500' : '' }}">Full-Time</a>
                            <a href="{{ route('dashboard', array_merge(request()->all(), ['filter' => 'Remote', 'search' => request('search')])) }}"
                                class="bg-gray-800 text-white px-3 py-1 rounded-full {{ request('filter') == 'Remote' ? 'bg-teal-500' : '' }}">Remote</a>
                            <a href="{{ route('dashboard', array_merge(request()->all(), ['filter' => 'Hybrid', 'search' => request('search')])) }}"
                                class="bg-gray-800 text-white px-3 py-1 rounded-full {{ request('filter') == 'Hybrid' ? 'bg-teal-500' : '' }}">Hybrid</a>
                            <a href="{{ route('dashboard', array_merge(request()->all(), ['filter' => 'Contract', 'search' => request('search')])) }}"
                                class="bg-gray-800 text-white px-3 py-1 rounded-full {{ request('filter') == 'Contract' ? 'bg-teal-500' : '' }}">Contract</a>

                            @if (request('filter'))
                                <a href="{{ route('dashboard', ['search' => request('search')]) }}"
                                    class="bg-gray-800 text-white px-3 py-1 rounded-full {{ request('filter') != null ? 'bg-red-500' : ''}}">Clear</a>
                            @endif

                            @if (request('search'))
                                <a href="{{ route('dashboard', ['filter' => request('filter')]) }}"
                                    class="bg-gray-800 text-white px-3 py-1 rounded-full {{ request('search') != null ? 'bg-red-500' : ''}}">Clear
                                    Search</a>

                            @endif
                        </div>
                    </div>

                    {{-- job List --}}
                    <div class="mt-8">
                        @if($jobs->count())
                            {{-- job title and job company name and sallary and the job type like a button at left --}}
                            @foreach ($jobs as $job)
                                <div class="bg-gray-800 p-4 rounded-lg mb-4 hover:bg-gray-700 transition duration-300">
                                    <a href="{{ route('jobVacancy.show', $job->id) }}">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h3 class="text-xl font-bold text-white">{{ $job->title }}</h3>
                                                <p class="text-gray-400">{{ $job->company->name }}</p>
                                                <p class="text-green-400 font-bold">${{ number_format($job->salary) }}</p>
                                            </div>
                                            <div class="text-right">
                                                <span
                                                    class="inline-block bg-blue-500 text-white px-3 py-1 rounded-full text-sm">{{ ucfirst($job->type) }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            @endforeach
                            {{-- Pagination --}}
                            <div class="mt-4">
                                {{ $jobs->withQueryString()->links() }}
                            </div>
                        @else
                            <p class="text-gray-400">{{ __('No jobs found.') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>