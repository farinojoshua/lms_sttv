<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'lecturer_id',
    ];

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function sections()
    {
        return $this->hasMany(CourseSection::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
