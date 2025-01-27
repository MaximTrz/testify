<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Test;
use Illuminate\Http\Request;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {


        $user = Auth::user();


        $group = $user->group;



        $currentTimestamp = Carbon::now();

        $tests = $group->tests()
            ->wherePivot('available_from', '<=', $currentTimestamp)
            ->wherePivot('available_until', '>=', $currentTimestamp)
            ->get();


        echo '<pre>';
            var_dump($tests);
        echo '</pre>';

        return view('tests.inwork');
    }

    public function completed()
    {
        return view('tests.completed');
    }

}
