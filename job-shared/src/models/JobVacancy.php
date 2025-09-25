<?php

namespace App\Models;

use Illuminate\Console\Application;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobVacancy extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'jobVacancies';

    protected $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'type',
        'deleted_at',
        'jobCategoryId',
        'views',
        'companyId',
    ];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'jobCategoryId');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'companyId');
    }

    public function applications(){
        return $this->hasMany(JobApplication::class,'jobVacancyId','id');
    }

}
