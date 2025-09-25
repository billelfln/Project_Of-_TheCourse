<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        {{-- Back button --}}
        <div class="mb-6">
            <a href="{{ route('jobVacancies.index', ['archived' => 'false']) }}"
                class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 transition duration-300 ease-in-out transform hover:scale-105">
                ← Back
            </a>
        </div>

        {{-- Job Vacancy Details --}}
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
            <div>
                <h3 class="text-lg font-semibold">Title: <span class="font-normal">{{ $jobVacancy->title }}</span></h3>
                <h3 class="text-lg font-semibold">Location: <span class="font-normal">{{ $jobVacancy->location }}</span>
                </h3>
                <h3 class="text-lg font-semibold">Salary: <span class="font-normal">{{ $jobVacancy->salary }}</span>
                </h3>
                <h3 class="text-lg font-semibold">Type: <span
                        class="font-normal">{{ ucfirst($jobVacancy->type) }}</span></h3>
                <h3 class="text-lg font-semibold">Category: <span
                        class="font-normal">{{ ucfirst($jobVacancy->category->name) }}</span></h3>
                <div class="mt-4">
                    <h3 class="text-lg font-semibold">Description:</h3>
                    <p class="text-gray-700 mt-2">{{ $jobVacancy->description }}</p>
                </div>
            </div>

            {{-- edit / archive / restore buttons --}}
            <div class="mt-6 flex space-x-4">
                <a href="{{ route('jobVacancies.edit', [$jobVacancy->id, 'redirectToList' => 'false']) }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition duration-300 ease-in-out transform hover:scale-105">
                    Edit
                </a>

                @if(is_null($jobVacancy->deleted_at))
                    <form action="{{ route('jobVacancies.destroy', $jobVacancy->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to archive this job vacancy?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition duration-300 ease-in-out transform hover:scale-105">
                            Archive
                        </button>
                    </form>
                @else
                    <form action="{{ route('jobVacancies.restore', $jobVacancy->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to restore this job vacancy?');">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition duration-300 ease-in-out transform hover:scale-105">
                            Restore
                        </button>
                    </form>
                @endif
            </div>

            {{-- Tabs for Applications + Company --}}
            <div class="mt-10" x-data="{ tab: 'applications' }">
                <!-- Tabs Header -->
                <div class="border-b border-gray-200 flex space-x-6">
                    <button @click="tab = 'applications'"
                        :class="tab === 'applications' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Applications
                    </button>
                    <button @click="tab = 'company'"
                        :class="tab === 'company' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Company
                    </button>
                </div>

                <!-- Tabs Content -->
                <div class="mt-6">
                    <!-- Applications Tab -->
                    <div x-show="tab === 'applications'" x-cloak>
                        <h3 class="text-lg font-semibold mb-4">Applications for {{ $jobVacancy->title }}</h3>
                        <table class="w-full border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm">#</th>
                                    <th class="px-4 py-2 text-left text-sm">Applicant</th>
                                    <th class="px-4 py-2 text-left text-sm">Status</th>
                                    <th class="px-4 py-2 text-left text-sm">AI Score</th>
                                    <th class="px-4 py-2 text-left text-sm">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($jobVacancy->applications as $application)
                                    <tr>
                                        <td class="px-4 py-2 text-sm">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2 text-sm">
                                            {{ $application->user ? $application->user->name : 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2 text-sm">{{ ucfirst($application->status) }}</td>
                                        <td class="px-4 py-2 text-sm">{{ $application->aiGeneratedScore ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 text-sm">
                                            <a href="#"
                                                class="px-3 py-1 bg-indigo-500 text-white text-xs rounded-lg shadow hover:bg-indigo-600 transition">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-2 text-center text-gray-500 text-sm">
                                            No applications found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Company Tab -->
                    <div x-show="tab === 'company'" x-cloak>
                        <h3 class="text-lg font-semibold mb-4">Company</h3>
                        @if($jobVacancy->company)
                            <div class="p-4 border rounded bg-gray-50">
                                <h4 class="text-md font-semibold">{{ $jobVacancy->company->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $jobVacancy->company->address }}</p>
                                <p class="text-sm text-gray-600">{{ $jobVacancy->company->industry }}</p>
                                <a href="{{ $jobVacancy->company->website }}" target="_blank"
                                    class="text-blue-500 hover:underline">
                                    {{ $jobVacancy->company->website }}
                                </a>
                            </div>
                        @else
                            <p class="text-gray-500">No company linked.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div id="success-message" class="bg-green-500 text-white px-4 py-2 rounded mt-6">
                    {{ session('success') }}
                </div>
            @endif
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
                setTimeout(() => message.remove(), 1000);
            }, 3000);
        }
    });
</script>