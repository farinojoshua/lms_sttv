<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'section_id',
        'title',
        'description',
        'start_time',
        'end_time',
    ];

    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'section_id');
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function submissions()
    {
        return $this->hasMany(QuizSubmission::class);
    }
}
