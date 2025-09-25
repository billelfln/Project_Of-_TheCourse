<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Application') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <form action="{{ route('job_applications.update', $application->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Applicant Info (read-only) -->
                    <div>
                        <p class="text-sm text-gray-500">Applicant</p>
                        <p class="font-medium text-gray-800">{{ $application->user?->name ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Job Vacancy</p>
                        <p class="font-medium text-gray-800">{{ $application->jobVacancy?->title ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Ai generated Score</p>
                        <p class="font-medium text-gray-800">{{ $application->aiGeneratedScore }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Ai Generated Feedback</p>
                        <p class="font-medium text-gray-800">{{ $application->aiGeneratedFeedback  }}</p>
                    </div>
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                   focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            @php
                                $statuses = ['pending', 'reviewed', 'accepted', 'rejected'];
                            @endphp
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ old('status', $application->status) == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('job_applications.edit', $application->id) }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-300 transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 text-white text-sm font-medium rounded-lg shadow
                                       bg-gradient-to-r from-indigo-500 to-purple-500
                                       hover:from-indigo-600 hover:to-purple-600 transition">
                            Update Status
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>