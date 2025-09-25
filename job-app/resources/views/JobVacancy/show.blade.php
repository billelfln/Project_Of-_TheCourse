<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $jobVacancy->title }} - Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl mx-auto">
            {{-- back button --}}
            <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline mb-4 inline-block">&larr; Back to
                Job Vacancies</a>
            {{-- job vacancy details --}}
            <div class="mb-6 flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold mb-4">{{ $jobVacancy->title }}</h1>
                    <p class="text-gray-300 mb-2"><strong>Company:</strong> {{ $jobVacancy->company->name }}</p>
                    <p class="text-gray-300 mb-2"><strong>Location:</strong> {{ $jobVacancy->location }}</p>
                    <p class="text-gray-300 mb-2"><strong>Salary:</strong>
                        {{ $jobVacancy->salary ? '$' . number_format($jobVacancy->salary, 2) : 'Not specified' }}</p>
                    {{-- job type --}}
                    <p class="text-gray-300 mb-2"><strong>Job Type:</strong> {{ $jobVacancy->type }}</p>
                </div>
                <div>
                    <a href="{{ route('jobVacancy.apply', $jobVacancy->id) }}"
                        class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">Apply Now</a>
                </div>
            </div>
            <hr class="border-gray-600 my-6" />

            {{-- Enhanced job description and summary with a modern design --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gray-900 rounded-lg p-6 shadow">
                    <h2 class="text-2xl font-semibold mb-4 text-teal-400">Job Description</h2>
                    <p class="text-gray-300 whitespace-pre-line">{{ $jobVacancy->description }}</p>
                </div>
                <div class="bg-gray-900 rounded-lg p-6 shadow flex flex-col justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold mb-4 text-teal-400">Job Summary</h2>
                        <ul class="list-disc list-inside text-gray-300 space-y-2">
                            <li><strong class="text-white">Posted on:</strong>
                                {{ $jobVacancy->created_at->format('F j, Y') }}</li>
                            <li><strong class="text-white">Deadline:</strong>
                                {{ $jobVacancy->application_deadline ? $jobVacancy->application_deadline->format('F j, Y') : 'Not specified' }}
                            </li>
                            <li><strong class="text-white">Location:</strong>
                                {{ $jobVacancy->location ?? 'Not specified' }}</li>
                            <li><strong class="text-white">Salary:</strong>
                                {{ $jobVacancy->salary ? '$' . number_format($jobVacancy->salary, 2) : 'Not specified' }}
                            </li>
                            <li><strong class="text-white">Job Type:</strong> {{ $jobVacancy->type ?? 'Not specified' }}
                            </li>
                            <li><strong class="text-white">Company:</strong> {{ $jobVacancy->company->name }}</li>
                            <li><strong class="text-white">Company Website:</strong>
                                <a href="{{ $jobVacancy->company->website }}" class="text-blue-400 hover:underline"
                                    target="_blank">{{ $jobVacancy->company->website }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

</x-app-layout>