<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    // sunction show()
    public function show($id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        return view('jobVacancy.show', compact('jobVacancy'));
    }

    // function apply()
    public function apply($id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        return view('jobVacancy.apply', compact('jobVacancy'));
    }

    public function storeApplication(Request $request, $id)
    {

        $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $jobVacancy = JobVacancy::findOrFail($id);
        dd($jobVacancy);
        // Handle file upload
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        } else {
            return back()->withErrors(['resume' => 'Resume upload failed.'])->withInput();
        }

        // Save application to database (assuming you have a JobApplication model)
        $jobVacancy->applications()->create([
            'name' => $request->input('name'),
            'resume_path' => $resumePath,
        ]);

        return redirect()->route('jobVacancy.show', $jobVacancy->id)->with('success', 'Application submitted successfully.');

    }
}
