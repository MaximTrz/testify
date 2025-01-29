<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function students()
    {
        return $this->hasMany(GroupStudent::class); // Связь "один ко многим" с таблицей GroupStudent
    }

//    public function tests()
//    {
//        return $this->belongsToMany(Test::class, 'test_group', 'group_id', 'test_id'); // Связь "многие ко многим" с тестами
//    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'test_group')
            ->withPivot('available_from', 'available_until');
    }


    public function users()
    {
        return $this->hasMany(User::class);
    }

}
