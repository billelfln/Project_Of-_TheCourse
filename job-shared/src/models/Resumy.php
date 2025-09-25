<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resumy extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = "resumies";
    //for uuid primary key not int is a string world ==>
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'fileName',
        'fileUrl',
        'contactDetails',
        'summary',
        'skills',
        'experience',
        'education',
        'deleted_at',
        'userId',

    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApllication::class, 'resumeId');
    }


}
