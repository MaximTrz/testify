<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'test_id',
        'question_text',
        'question_type',
        'time_limit',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

}
