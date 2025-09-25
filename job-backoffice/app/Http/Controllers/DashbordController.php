<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashbordController extends Controller
{
    public function __construct(private DashboardService $dashboardService){

    }
    public function index()
    {
        // تحقق إذا كان المستخدم مديرًا، ثم نفذ منطق الادمن
        if (Auth::user() && Auth::user()->role == 'admin') {
           $analytics=$this->dashboardService->admin();
        } else {
            $analytics= $this->dashboardService->companyOwnerDashboard();
        }
        return view('dashboard.index', compact('analytics'));

    }
}