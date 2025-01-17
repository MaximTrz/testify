<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradingCriteria extends Model
{
    use HasFactory;

    protected $table = 'grading_criteria';

    protected $fillable = [
        'test_id',
        'min_correct_answers',
        'max_correct_answers',
        'grade',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

}
