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

        return view('tests.inwork', compact('tests'));

    }

    public function completed()
    {
        return view('tests.completed');
    }

    public function show($id)
    {
        $user = Auth::user();

        $group = $user->group;

        $currentTimestamp = Carbon::now();

        $test = $group->tests()
            ->with('gradingCriteria')
            ->where('tests.id', $id)
            ->wherePivot('available_from', '<=', $currentTimestamp)
            ->wherePivot('available_until', '>=', $currentTimestamp)
            ->withCount('questions')
            ->first();

        if (!$test) {
            abort(404, 'Тест не найден или недоступен.');
        }

        return view('tests.show', compact('test'));
    }

    public function getTest($id)
    {
        $user = Auth::user();
        $group = $user->group;
        $currentTimestamp = Carbon::now();


        $test = $group->tests()
            ->with([
                'gradingCriteria',
                'questions.answers' => function ($query) {
                    $query->select('id', 'question_id', 'answer_text');
                }
            ])
            ->where('tests.id', $id)
            ->wherePivot('available_from', '<=', $currentTimestamp)
            ->wherePivot('available_until', '>=', $currentTimestamp)
            // ->withCount('questions') // Uncomment if needed
            ->first();

        $test->pivot->available_from = Carbon::parse($test->pivot->available_from)->translatedFormat('d.m.Y H:i');
        $test->pivot->available_until = Carbon::parse($test->pivot->available_until)->translatedFormat('d.m.Y H:i');


        if (!$test) {
            return response()->json([
                'message' => 'Тест не найден или недоступен.'
            ], 404);
        }

        return response()->json($test);
    }

}
