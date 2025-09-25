<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobApplication::with(['jobVacancy', 'user', 'resumy'])->latest();
        
        
        $company = Company::where('ownerId', Auth::user()->id)->first();

        if ($company) {
        // ✅ نعرض فقط الطلبات المرتبطة بالشركة الخاصة بالـ owner
        $query->whereHas('jobVacancy', function ($q) use ($company) {
            $q->where('companyId', $company->id);
        });
    }

        if ($request->input('archived') == 'true') {
            $query->onlyTrashed();
            $archived = 'true';
        } else {
            $archived = 'false';
        }

        $applications = $query->paginate(10)->onEachSide(1);

        return view('application.index', compact('applications', 'archived'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $application = JobApplication::with(['jobVacancy', 'user', 'resumy'])->findOrFail($id);

        return view('application.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $application = JobApplication::findOrFail($id);

        return view('application.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $application = JobApplication::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|max:50|in:pending,accepted,rejected',
        ]);

        $application->update($validated);

        return redirect()->route('job_applications.index')
                         ->with('success', 'Application updated successfully.');
    }

    /**
     * Archive (soft delete) the specified resource.
     */
    public function destroy(string $id)
    {
        $application = JobApplication::findOrFail($id);
        $application->delete();

        return redirect()->route('job_applications.index')
                         ->with('success', 'Application archived successfully.');
    }

    /**
     * Restore a soft-deleted application.
     */
    public function restore(string $job_application)
    {
        $application = JobApplication::onlyTrashed()->findOrFail($job_application);
        $application->restore();

        return redirect()->route('job_applications.index', ['archived' => 'true'])
                         ->with('success', 'Application restored successfully.');
    }
}
