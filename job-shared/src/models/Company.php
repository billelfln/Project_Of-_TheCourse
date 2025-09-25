<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = "companies";
    protected $fillable = [
        "name",
        "address",
        "industry",
        "website",
        "deleted_at",
        "ownerId",
    ];
    protected $dates = ['deleted_at'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'ownerId');
    }

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'companyId');
    }   

      public function applications()
    {
        return $this->hasManyThrough(
            JobApplication::class,   // الموديل النهائي
            JobVacancy::class,              // الموديل الوسيط
            'companyId',             // المفتاح الأجنبي في جدول jobs (يربطه بالشركة)
            'jobVacancyId',          // المفتاح الأجنبي في جدول applications (يربطه بالـ job)
            'id',                    // المفتاح الأساسي في جدول companies
            'id'                     // المفتاح الأساسي في جدول jobs
        );
    }




}
