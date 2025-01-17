<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $table = 'tests';

    protected $fillable = [
        'title',
        'time_limit',
        'teacher_id',
        'available_from',
        'available_until',
        'status',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function gradingCriteria()
    {
        return $this->hasMany(GradingCriteria::class);
    }

    public function testGroup()
    {
        return $this->hasMany(TestGroup::class);
    }

    public function results()
    {
        return $this->hasMany(TestResult::class);
    }

}
