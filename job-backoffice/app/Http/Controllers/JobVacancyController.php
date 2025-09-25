<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use App\Models\Company;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobVacancyController extends Controller
{
    public $types =['Full-Time', 'Contract', 'Remote', 'Hybrid'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = JobVacancy::latest();

        // إذا كان المستخدم مالك شركة، أظهر فقط الوظائف الخاصة بشركته
        if ($user && $user->role === 'company-owner') {
            $query->where('companyId', $user->company->id);
        }

        if ($request->input('archived') == 'true') {
            $query->onlyTrashed();
        }

        $jobVacancies = $query->paginate(perPage: 10)->onEachSide(1);
        $archived = $request->input('archived', 'false');
        return view('job_vacancy.index', compact('jobVacancies', 'archived'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = $this->types;
        $companies = Company::all(); // لاختيار الشركة المرتبطة
        $categories=JobCategory::all();
        
        return view('job_vacancy.create', compact('types', 'companies','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
            'salary'      => 'nullable|numeric|min:0',
            'type'        => 'required|string|in:' . implode(',', $this->types),
            'jobCategoryId' => 'required|uuid',
            'companyId'     => 'required|uuid',
        ]);

        JobVacancy::create($validatedData);

        return redirect()->route('jobVacancies.index')
            ->with('success', 'Job vacancy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        return view('job_vacancy.show', compact('jobVacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $types = $this->types;
        $companies = Company::all();
                $categories=JobCategory::all();

        return view('job_vacancy.edit', compact('jobVacancy', 'types', 'companies','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
            'salary'      => 'nullable|numeric|min:0',
            'type'        => 'required|string|in:' . implode(',', $this->types),
            'jobCategoryId' => 'required|uuid',
            'companyId'     => 'required|uuid',
        ]);

        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->update($validatedData);
       
        if ($request->query('redirectToList') == 'true') {
            return redirect()->route('jobVacancies.index')
                ->with('success', 'Job vacancy updated successfully.');
        }

        return redirect()->route('jobVacancies.show', $id)
            ->with('success', 'Job vacancy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();
        return redirect()->route('jobVacancies.index')
            ->with('success', 'Job vacancy archived successfully.');
    }

    /**
     * Restore the specified resource.
     */
    public function restore(string $jobVacancy)
    {
        $jobVacancy = JobVacancy::withTrashed()->findOrFail($jobVacancy);
        $jobVacancy->restore();
        return redirect()->route('jobVacancies.index', ['archived' => 'true'])
            ->with('success', 'Job vacancy restored successfully.');
    }
}
