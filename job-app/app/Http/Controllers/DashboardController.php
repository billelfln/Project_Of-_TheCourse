<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Pagination\PaginationServiceProvider;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        // with Pagination
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);
        $search = $request->input('search');
        $filter=$request->input('filter');
        if ($search && !$filter) {
            // but the company is a relationship
            $jobs = JobVacancy::where('title', 'like', '%' . $search . '%')
                ->orWhereHas('company', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->paginate(10);
        }
        else if($filter && !$search){
            $jobs = JobVacancy::where('type', $filter)->paginate(10);
        }  
        else if($filter && $search){
            $jobs = JobVacancy::where('type', $filter)
            ->where(function($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                      ->orWhereHas('company', function ($query) use ($search) {
                          $query->where('name', 'like', '%' . $search . '%');
                      });
            })
            ->paginate(10);
        }
        else {
            $jobs = JobVacancy::paginate(10);
        }
        return view('dashboard', compact('jobs'));
    }
}
