<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Job Application #{{ $application->id }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        {{-- Back button --}}
        <div class="mb-6">
            <a href="{{ route('job_applications.index', ['archived' => 'false']) }}"
                class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 transition duration-300 ease-in-out transform hover:scale-105">
                ← Back
            </a>
        </div>


        {{-- Job Application Details --}}
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
            <div>
                <h3 class="text-lg font-semibold">Applicant:
                    <span class="font-normal">{{ $application->user?->name ?? 'N/A' }}</span>
                </h3>
                <h3 class="text-lg font-semibold">Job Vacancy:
                    <span class="font-normal">{{ $application->jobVacancy?->title ?? 'N/A' }}</span>
                </h3>
                <h3 class="text-lg font-semibold">Company:
                    <span class="font-normal">{{ $application->jobVacancy?->company?->name ?? 'N/A' }}</span>
                </h3>
                <h3 class="text-lg font-semibold">
                    Status:
                    <span class="
        font-normal 
        @if($application->status === 'pending') text-yellow-500 
        @elseif($application->status === 'accepted') text-green-600 
        @elseif($application->status === 'rejected') text-red-600 
        @else text-gray-600 
        @endif
    ">
                        {{ ucfirst($application->status) }}
                    </span>
                </h3>


                <h3 class="text-lg font-semibold">
                    Resumy:
                    <a href="{{ asset('storage/' . $application->resumy->fileUrl) }}" target="_blank"
                        class="text-blue-600 underline hover:text-blue-800">
                        {{ ucfirst(basename($application->resumy->fileUrl)) }}
                    </a>
                </h3>

            </div>

            {{-- Edit / Archive / Restore --}}
            <div class="mt-6 flex space-x-4">
                {{-- Edit --}}
                <a href="{{ route('job_applications.edit', [$application->id, 'redirectToList' => 'false']) }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition duration-300 ease-in-out transform hover:scale-105">
                    Edit
                </a>

                {{-- Archive / Restore --}}
                @if(is_null($application->deleted_at))
                    <form action="{{ route('job_applications.destroy', $application->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to archive this application?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition duration-300 ease-in-out transform hover:scale-105">
                            Archive
                        </button>
                    </form>
                @else
                    <form action="{{ route('job_applications.restore', $application->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to restore this application?');">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition duration-300 ease-in-out transform hover:scale-105">
                            Restore
                        </button>
                    </form>
                @endif
            </div>
            {{-- Tabs for Resume + AI Feedback --}}
            <div class="mt-10" x-data="{ tab: 'resume' }">
                <!-- Tabs Header -->
                <div class="border-b border-gray-200 flex space-x-6">
                    <button @click="tab = 'resume'"
                        :class="tab === 'resume' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Resume
                    </button>
                    <button @click="tab = 'ai'"
                        :class="tab === 'ai' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        AI Feedback
                    </button>
                </div>

                <!-- Tabs Content -->
                <div class="mt-6">
                    <!-- Resume Tab -->
                    <div x-show="tab === 'resume'" x-cloak>
                        <h3 class="text-lg font-semibold mb-4">Resume</h3>
                        @if($application->resumy)
                            <div class="p-4 border rounded bg-gray-50">
                                <table class="w-full border border-gray-200 rounded-lg">
                                    <tbody class="divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-4 py-2 font-semibold w-1/4">Summary</td>
                                            <td class="px-4 py-2 text-gray-700">
                                                {{ $application->resumy->summary ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-2 font-semibold">Skills</td>
                                            <td class="px-4 py-2 text-gray-700">
                                                {{ $application->resumy->skills ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-2 font-semibold">Experience</td>
                                            <td class="px-4 py-2 text-gray-700">
                                                {{ $application->resumy->experience ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-2 font-semibold">Education</td>
                                            <td class="px-4 py-2 text-gray-700">
                                                {{ $application->resumy->education ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500">No resume uploaded.</p>
                        @endif
                    </div>


                    <!-- AI Feedback Tab -->
                    <div x-show="tab === 'ai'" x-cloak>
                        <h3 class="text-lg font-semibold mb-4">AI Feedback</h3>
                        @if($application->aiGeneratedScore || $application->aiGeneratedFeedback)
                            <div class="p-4 border rounded bg-gray-50 space-y-2">
                                <p><strong>AI Score:</strong> {{ $application->aiGeneratedScore ?? 'N/A' }}</p>
                                <p><strong>Feedback:</strong></p>
                                <p class="text-gray-700">{{ $application->aiGeneratedFeedback ?? 'No feedback available.' }}
                                </p>
                            </div>
                        @else
                            <p class="text-gray-500">No AI feedback generated.</p>
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