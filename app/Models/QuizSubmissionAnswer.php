<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizSubmissionAnswer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'submission_id',
        'question_id',
        'selected_answer',
        'is_correct',
    ];

    public function submission()
    {
        return $this->belongsTo(QuizSubmission::class, 'submission_id');
    }

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }
}
