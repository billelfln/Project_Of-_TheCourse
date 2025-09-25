<?php

namespace App\Services;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * إحصائيات لوحة تحكم الأدمن
     */
    public function admin(): array
    {
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))->count();
        $activeJobs = JobVacancy::whereNull('deleted_at')->count();
        $totalApplications = JobApplication::count();

        $mostAppliedJobs = JobVacancy::with('company')
            ->withCount('applications')
            ->orderByDesc('applications_count')
            ->take(5)
            ->get();

        $topConvertingJobs = JobVacancy::withCount('applications')
            ->orderByDesc(DB::raw('applications_count / NULLIF(views,0)'))
            ->take(5)
            ->get();
        
        

        return [
            'activeUsers'        => $activeUsers,
            'activeJobs'         => $activeJobs,
            'totalApplications'  => $totalApplications,
            'mostAppliedJobs'    => $mostAppliedJobs,
            'topConvertingJobs'  => $topConvertingJobs,
        ];
    }

    /**
     * إحصائيات لوحة تحكم صاحب الشركة
     */
    public function companyOwnerDashboard(): array
    {
        $user = Auth::user();
        $company = $user?->company;

        if (!$company) {
            return [
                'companyJobs'         => 0,
                'companyApplications' => 0,
                'mostAppliedJobs'     => collect(),
                'topConvertingJobs'   => collect(),
            ];
        }

        $companyJobs = $company->jobVacancies()->count();
        $companyApplications = $company->applications()->count();

        $mostAppliedJobs = $company->jobVacancies()
            ->withCount('applications')
            ->orderByDesc('applications_count')
            ->take(5)
            ->get();

        $topConvertingJobs = $company->jobVacancies()
            ->withCount('applications')
            ->orderByDesc(DB::raw('applications_count / NULLIF(views,0)'))
            ->take(5)
            ->get();

        return [
            'companyJobs'         => $companyJobs,
            'companyApplications' => $companyApplications,
            'mostAppliedJobs'     => $mostAppliedJobs,
            'topConvertingJobs'   => $topConvertingJobs,
        ];
    }
}
