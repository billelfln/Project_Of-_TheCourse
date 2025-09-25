<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ $company->name }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">



        {{-- Back button --}}
        <div class="mb-6">
            <a href="{{route('companies.index')}}"
                class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 transition duration-300 ease-in-out transform hover:scale-105">
                ← Back
            </a>
        </div>



        {{-- company details --}}
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
            <div>
                <h3 class="text-lg font-semibold">Name: <span class="font-normal">{{ $company->name }}</span></h3>
                <h3 class="text-lg font-semibold">Address: <span class="font-normal">{{ $company->address }}</span></h3>
                <h3 class="text-lg font-semibold">Industry: <span class="font-normal">{{ $company->industry }}</span>
                    <h3 class="text-lg font-semibold">Email: <span
                            class="font-normal">{{ $company->owner->email }}</span>
                    </h3>
                    <h3 class="text-lg font-semibold">
                        Website:
                        <a href="{{ $company->website }}" class="text-blue-500 hover:underline" target="_blank">
                            {{ $company->website }}
                        </a>
                    </h3>
            </div>

            {{-- edit and archive buttons --}}
            <div class="mt-6 flex space-x-4">
                @if(auth()->user()->role == 'admin')
                    <a href="{{ route('companies.edit', [$company->id, 'redirectToList' => 'false'])  }}"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition duration-300 ease-in-out transform hover:scale-105">
                        Edit
                    </a>
                @endif

                @if(auth()->user()->role == 'company-owner')

                    <a href="{{ route('mycompany.edit')  }}"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition duration-300 ease-in-out transform hover:scale-105">
                        Edit
                    </a>


                @endif

                @if(is_null($company->deleted_at))
                    @if(auth()->user()->role == 'admin')
                        <form action="{{ route('companies.destroy', $company->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to archive this company?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition duration-300 ease-in-out transform hover:scale-105">
                                Archive
                            </button>
                        </form>
                    @endif
                @else
                    <form action="{{ route('companies.restore', $company->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to restore this company?');">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition duration-300 ease-in-out transform hover:scale-105">
                            Restore
                        </button>
                    </form>
                @endif
            </div>
            @if(auth()->user()->role == 'admin')
                {{-- tabs navigation for jobs and applications --}}
                <div class="mt-10" x-data="{ tab: 'jobs' }">
                    <!-- Tabs Header -->
                    <div class="border-b border-gray-200 flex space-x-6">
                        <button @click="tab = 'jobs'"
                            :class="tab === 'jobs' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Jobs
                        </button>
                        <button @click="tab = 'applications'"
                            :class="tab === 'applications' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Applications
                        </button>
                    </div>

                    <!-- Tabs Content -->
                    <div class="mt-6">
                        <!-- Jobs Tab -->
                        <div x-show="tab === 'jobs'" x-cloak>
                            <h3 class="text-lg font-semibold mb-4">Jobs at {{ $company->name }}</h3>
                            <table class="w-full border border-gray-200 rounded-lg">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm">#</th>
                                        <th class="px-4 py-2 text-left text-sm">Title</th>
                                        <th class="px-4 py-2 text-left text-sm">Location</th>
                                        <th class="px-4 py-2 text-left text-sm">Salary</th>
                                        <th class="px-4 py-2 text-left text-sm">Type</th>
                                        <th class="px-4 py-2 text-left text-sm">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($company->jobVacancies as $job)
                                        <tr>
                                            <td class="px-4 py-2 text-sm">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-2 text-sm">
                                                {{-- // @TODO: Replace # => {{ route('applications.show', $application->id) }}
                                                --}}
                                                <a href="" class="text-indigo-600 hover:underline">
                                                    {{ $job->title }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-2 text-sm">{{ $job->location }}</td>
                                            <td class="px-4 py-2 text-sm">{{ $job->salary }}</td>
                                            <td class="px-4 py-2 text-sm">{{ ucfirst($job->type) }}</td>

                                            {{-- <td class="px-4 py-2 text-sm">{{ $job->created_at->format('Y-m-d') }}</td> --}}
                                            {{-- // @TODO: Replace # => {{ route('applications.show', $application->id) }}
                                            --}}
                                            <td class="px-4 py-2 text-sm">
                                                <a href="#"
                                                    class="px-3 py-1 bg-indigo-500 text-white text-xs rounded-lg shadow hover:bg-indigo-600 transition">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-4 py-2 text-center text-gray-500 text-sm">
                                                No jobs found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Applications Tab -->
                        <div x-show="tab === 'applications'" x-cloak>
                            <h3 class="text-lg font-semibold mb-4">Applications for {{ $company->name }}</h3>
                            <table class="w-full border border-gray-200 rounded-lg">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm">#</th>
                                        <th class="px-4 py-2 text-left text-sm">Applicant</th>
                                        <th class="px-4 py-2 text-left text-sm">Job</th>
                                        <th class="px-4 py-2 text-left text-sm">Status</th>
                                        <th class="px-4 py-2 text-left text-sm">AI Score</th>
                                        {{-- <th class="px-4 py-2 text-left text-sm">Applied At</th> --}}
                                        <th class="px-4 py-2 text-left text-sm">Actions</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    @forelse($company->applications as $application)
                                        <tr>
                                            <td class="px-4 py-2 text-sm">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-2 text-sm">
                                                {{ $application->user ? $application->user->name : 'N/A' }}
                                            </td>
                                            <td class="px-4 py-2 text-sm">
                                                {{ $application->jobVacancy ? $application->jobVacancy->title : '-' }}
                                            </td>
                                            <td class="px-4 py-2 text-sm">{{ ucfirst($application->status) }}</td>
                                            <td class="px-4 py-2 text-sm">{{ $application->aiGeneratedScore ?? 'N/A' }}</td>

                                            {{-- <td class="px-4 py-2 text-sm">{{ $application->created_at->format('Y-m-d') }}
                                            </td> --}}

                                            {{-- // @TODO: Replace # => {{ route('applications.show', $application->id) }}
                                            --}}
                                            <td class="px-4 py-2 text-sm">
                                                <a href="#"
                                                    class="px-3 py-1 bg-indigo-500 text-white text-xs rounded-lg shadow hover:bg-indigo-600 transition">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-4 py-2 text-center text-gray-500 text-sm">
                                                No applications found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(session('success'))
                        <div id="success-message" class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif


                </div>
            @endif
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