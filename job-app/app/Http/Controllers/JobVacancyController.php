<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\Resumy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of job vacancies with search and filtering.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = JobVacancy::query()->with('company');

        // Apply search filters
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('location', 'like', "%{$searchTerm}%");
            });
        }

        // Apply filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        $jobVacancies = $query->orderBy('created_at', 'desc')
                             ->paginate(12);

        return view('jobVacancy.index', compact('jobVacancies'));
    }

    /**
     * Display the specified job vacancy.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        try {
            $jobVacancy = JobVacancy::with(['company', 'applications'])
                                   ->findOrFail($id);

            // Increment view count
            $jobVacancy->increment('views');

            // Get similar jobs
            $similarJobs = $this->getSimilarJobs($jobVacancy);

            // Check if user has already applied (if authenticated)
            $hasApplied = false;
            if (Auth::check()) {
                $hasApplied = $this->hasUserApplied(Auth::user(), $jobVacancy);
            }

            return view('jobVacancy.show', compact('jobVacancy', 'similarJobs', 'hasApplied'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('jobVacancy.index')
                ->with('error', 'Job vacancy not found.');
        }
    }

    /**
     * Show the application form for a job vacancy.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function apply($id)
    {
        try {
            $jobVacancy = JobVacancy::with('company')->findOrFail($id);

            // Check if user is authenticated
            if (!Auth::check()) {
                return redirect()
                    ->route('login')
                    ->with('message', 'Please login to apply for this position.');
            }

            // Check if vacancy is still open
            if (!$this->isVacancyOpen($jobVacancy)) {
                return redirect()
                    ->route('jobVacancy.show', $id)
                    ->with('error', 'This position is no longer accepting applications.');
            }

            // Check if user already applied
            if ($this->hasUserApplied(Auth::user(), $jobVacancy)) {
                return redirect()
                    ->route('jobVacancy.show', $id)
                    ->with('info', 'You have already applied for this position.');
            }

            return view('jobVacancy.apply', compact('jobVacancy'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('jobVacancy.index')
                ->with('error', 'Job vacancy not found.');
        }
    }


    /**
     * Store a new job application.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeApplication(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Validate request
            $validated = $request->validate([
                'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            ]);

            $jobVacancy = JobVacancy::findOrFail($id);

            // Check if vacancy is still open
            if (!$this->isVacancyOpen($jobVacancy)) {
                return redirect()
                    ->back()
                    ->with('error', 'This position is no longer accepting applications.');
            }

            // Check if user already applied
            if ($this->hasUserApplied($request->user(), $jobVacancy)) {
                return redirect()
                    ->back()
                    ->with('error', 'You have already applied for this position.');
            }

            // Store resume file
            $resumePath = $this->storeResumeFile($request->file('resume'));

            // Create and save resume
            $resume = $this->createResume($request->user(), $request->file('resume'), $resumePath);

            // Create and save job application
            $jobApplication = $this->createJobApplication($request->user(), $jobVacancy, $resume);

            DB::commit();

            return redirect()
                ->route('jobVacancy.show', $jobVacancy->id)
                ->with('success', 'Application submitted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Application submission failed: ' . $e->getMessage(), [
                'user_id' => $request->user()->id,
                'job_vacancy_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->with('error', 'There was an error submitting your application. Please try again.')
                ->withInput();
        }
    }

    /**
     * Store the uploaded resume file
     */
    private function storeResumeFile($file)
    {
        return $file->store('resumes', 'public');
    }

    /**
     * Create and save resume record
     */
    private function createResume($user, $file, $resumePath)
    {
        $resume = new Resumy();
        $resume->userId = $user->id;
        $resume->fileName = $file->getClientOriginalName();
        $resume->FileUrl = '/storage/' . $resumePath;
        $resume->contactDetails = $user->email;
        
        // Simulated AI extracted data (to be replaced with actual AI integration)
        $resume->summary = 'This is a simulated summary of the resume.';
        $resume->skills = 'Laravel, PHP, MySQL, Teamwork';
        $resume->experience = 'Simulated experience: 2 years in web development.';
        $resume->education = 'Simulated education: Computer Science Degree.';
        
        $resume->save();

        return $resume;
    }

    /**
     * Create and save job application
     */
    private function createJobApplication($user, $jobVacancy, $resume)
    {
        $jobApplication = new JobApplication();
        $jobApplication->userId = $user->id;
        $jobApplication->jobVacancyId = $jobVacancy->id;
        $jobApplication->resumeId = $resume->id;
        $jobApplication->status = 'pending';
        
        // Simulated AI-generated feedback (to be replaced with actual AI integration)
        $jobApplication->aiGeneratedScore = rand(60, 95);
        $jobApplication->aiGeneratedFeedback = 'Simulated feedback: Candidate seems like a good fit.';
        
        $jobApplication->save();

        return $jobApplication;
    }

    /**
     * Check if the job vacancy is still open for applications.
     *
     * @param JobVacancy $jobVacancy
     * @return bool
     */
    private function isVacancyOpen(JobVacancy $jobVacancy): bool
    {
        // For now, assume all vacancies are open since we don't have status/deadline fields
        // TODO: Add status and deadline fields to JobVacancy model and migration
        return true;
    }

    /**
     * Check if user has already applied for this vacancy.
     *
     * @param \App\Models\User $user
     * @param JobVacancy $jobVacancy
     * @return bool
     */
    private function hasUserApplied($user, JobVacancy $jobVacancy): bool
    {
        return JobApplication::where('userId', $user->id)
            ->where('jobVacancyId', $jobVacancy->id)
            ->exists();
    }

    /**
     * Get similar job vacancies based on type and location.
     *
     * @param JobVacancy $jobVacancy
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getSimilarJobs(JobVacancy $jobVacancy)
    {
        return JobVacancy::where('id', '!=', $jobVacancy->id)
            ->where(function($query) use ($jobVacancy) {
                $query->where('type', $jobVacancy->type)
                      ->orWhere('location', $jobVacancy->location);
            })
            ->with('company')
            ->limit(3)
            ->get();
    }
}
