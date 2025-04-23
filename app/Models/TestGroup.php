<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestGroup extends Model
{
    use HasFactory;

    protected $table = 'test_group';

    protected $fillable = [
        'test_id',
        'group_id',
        'teacher_id'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function results()
    {
        return $this->hasMany(TestResult::class);
    }

}
