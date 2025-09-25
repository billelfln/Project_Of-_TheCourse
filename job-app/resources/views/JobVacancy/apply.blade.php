<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $jobVacancy->title }} - Apply Now
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl mx-auto">
            {{-- back button --}}
            <a href="{{ route('jobVacancy.show', $jobVacancy->id) }}"
                class="text-blue-500 hover:underline mb-4 inline-block">&larr; Back to
                Job Details</a>
            {{-- job vacancy details --}}
            <div class="mb-6 flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold mb-4 text-white">{{ $jobVacancy->title }}</h1>
                    <p class="text-gray-300 mb-2"><strong>Company:</strong> {{ $jobVacancy->company->name }}</p>
                    <p class="text-gray-300 mb-2"><strong>Location:</strong> {{ $jobVacancy->location }}</p>
                    <p class="text-gray-300 mb-2"><strong>Salary:</strong>
                        {{ $jobVacancy->salary ? '$' . number_format($jobVacancy->salary, 2) : 'Not specified' }}</p>
                    {{-- job type --}}
                    <p class="text-gray-300 mb-2"><strong>Job Type:</strong> {{ $jobVacancy->type }}</p>
                </div>
            </div>
            <hr class="border-gray-600 my-6" />

            {{-- Application Form --}}
            <form action="{{ route('jobVacancy.storeApplication', $jobVacancy->id) }}" method="POST"
                enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="jobVacancyId" value="{{ $jobVacancy->id }}">

                {{-- Choose Your Resume Section --}}
                <div class="bg-black p-6">
                    <h3 class="text-white text-xl font-semibold mb-6">Choose Your Resume</h3>

                    {{-- Existing Resumes --}}
                    @if(auth()->user()->resumes && auth()->user()->resumes->count() > 0)
                        <div class="mb-6">
                            <label class="text-gray-300 text-sm font-medium mb-3 block">Select from your existing
                                resumes:</label>
                            <div class="space-y-2">
                                @foreach(auth()->user()->resumes as $resume)
                                    <div class="flex items-center">
                                        <input type="radio" id="resume_{{ $resume->id }}" name="resume_selection"
                                            value="existing_{{ $resume->id }}"
                                            class="w-4 h-4 text-purple-600 bg-gray-700 border-gray-600 focus:ring-purple-500 focus:ring-2">
                                        <label for="resume_{{ $resume->id }}" class="ml-2 text-gray-300 cursor-pointer">
                                            {{ $resume->name ?? 'Resume ' . $loop->iteration }}
                                            <span
                                                class="text-gray-500 text-sm">({{ $resume->created_at->format('M d, Y') }})</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Upload New Resume --}}
                    <div class="mb-6">
                        <div class="flex items-center mb-3">
                            <input type="radio" id="new_resume" name="resume_selection" value="new"
                                class="w-4 h-4 text-purple-600 bg-gray-700 border-gray-600 focus:ring-purple-500 focus:ring-2">
                            <label for="new_resume" class="ml-2 text-gray-300 text-sm font-medium cursor-pointer">
                                Or upload a new resume:
                            </label>
                        </div>

                        {{-- File Upload Area --}}
                        <div class="mt-3">
                            <div class="flex items-center justify-center w-full">
                                <label for="resume_file"
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-cyan-500 border-dashed rounded-lg cursor-pointer bg-black hover:bg-gray-900 transition-colors duration-200">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-cyan-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-cyan-500">
                                            <span class="font-semibold">Click to upload</span> or drag and drop
                                        </p>
                                        <p class="text-xs text-gray-400">PDF, DOC, DOCX (MAX. 10MB)</p>
                                    </div>
                                    <input id="resume_file" name="resume" type="file" class="hidden"
                                        accept=".pdf,.doc,.docx" />
                                </label>
                            </div>
                            <p class="mt-2 text-xs text-gray-400">
                                Selected file: <span id="selected-file-name" class="text-cyan-400">None</span>
                            </p>
                        </div>
                    </div>

                    {{-- Apply Button --}}
                    <div class="mt-8">
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Apply Now
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    {{-- JavaScript for file upload functionality --}}
    <script>
        document.getElementById('resume_file').addEventListener('change', function (e) {
            const fileName = e.target.files[0]?.name || 'None';
            document.getElementById('selected-file-name').textContent = fileName;

            // Auto-select the "new resume" radio button when file is chosen
            if (e.target.files[0]) {
                document.getElementById('new_resume').checked = true;
            }
        });

        // Auto-select radio button when clicking on file upload area
        document.querySelector('label[for="resume_file"]').addEventListener('click', function () {
            document.getElementById('new_resume').checked = true;
        });
    </script>
</x-app-layout>