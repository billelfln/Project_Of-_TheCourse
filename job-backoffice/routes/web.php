<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

Route::middleware(['auth','role:company-owner,admin'])->group(function () {
    Route::get('/', [DashbordController::class, 'index'])->name('dashboard');


   

    Route::resource('job_applications', ApplicationController::class);
    Route::post('job_applications/{job_application}/restore', [ApplicationController::class, 'restore'])->name('job_applications.restore');

    Route::resource('jobVacancies', JobVacancyController::class);
        Route::post('jobVacancies/{jobVacancy}/restore', [JobVacancyController::class, 'restore'])->name('jobVacancies.restore');

   

});

//comany-owner

Route::middleware(['auth','role:company-owner'])->group(function (){
    Route::get('/my-company',[CompanyController::class,'show'])->name('mycompany.show');
     // فورم التعديل
    Route::get('/my-company/edit', [CompanyController::class, 'edit'])
        ->name('mycompany.edit');

    // تنفيذ التحديث
    Route::put('/my-company', [CompanyController::class, 'update'])
        ->name('mycompany.update');
});


//admin
Route::middleware(['auth','role:admin'])->group(function (){

     //categories
    Route::resource('categories', CategoryController::class);
    Route::post('categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore');

    //resource for comany
    Route::resource('companies', CompanyController::class);
    Route::post('companies/{company}/restore', [CompanyController::class, 'restore'])->name('companies.restore');

    //users
     Route::resource('users', UserController::class);
});

// Language switching route (available to all authenticated users)
Route::middleware('auth')->group(function() {
    Route::post('/language/switch', [LanguageController::class, 'switch'])->name('language.switch');
});

require __DIR__ . '/auth.php';