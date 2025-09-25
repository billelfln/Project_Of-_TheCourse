<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'jobApplications';

    protected $fillable = [
        'status',
        'aiGeneratedScore',
        'aiGeneratedFeedback',
        'jobVacancyId',
        'resumeId',
        'deleted_at',
        'userId',

    ];

    protected $dates = ['deleted_at'];

    public function resumy()
    {
        return $this->belongsTo(Resumy::class, 'resumeId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'jobVacancyId');
    }

}
