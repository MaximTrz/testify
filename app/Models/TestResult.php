<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $table = 'test_results';

    protected $fillable = [
        'test_id',
        'student_id',
        'score',
        'completed_at',
        'group_id',
        'teacher_id',
        'grade'
    ];

    //public $timestamps = false; // Отключаем timestamps, если их нет

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

}
