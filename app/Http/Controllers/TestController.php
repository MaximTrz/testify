<?php

namespace App\Http\Controllers;


use App\Models\Group;
use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

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

        // Получаем список ID тестов, которые пользователь уже выполнил
        $completedTestIds = TestResult::where('student_id', $user->id)
            ->pluck('test_id');

        // Получаем доступные тесты, исключая выполненные
        $tests = $group->tests()
            ->wherePivot('available_from', '<=', $currentTimestamp)
            ->wherePivot('available_until', '>=', $currentTimestamp)
            ->whereNotIn('tests.id', $completedTestIds)
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

        if ($this->hasUserCompletedTest($id)) {
            abort(403, 'Вы уже выполняли этот тест.');
        }

        $test = $group->tests()
            ->select('tests.id', 'tests.title')
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

    public function testing()
    {
        return view('tests.testing');
    }

    public function getTest($id)
    {
        $user = Auth::user();
        $group = $user->group;
        $currentTimestamp = Carbon::now();


        if ($this->hasUserCompletedTest($id)) {
            abort(403, 'Вы уже выполняли этот тест.');
        }

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
            // ->withCount('questions') //
            ->first();

        $test->pivot->available_from = Carbon::parse($test->pivot->available_from)->translatedFormat('d.m.Y H:i');
        $test->pivot->available_until = Carbon::parse($test->pivot->available_until)->translatedFormat('d.m.Y H:i');


        if (!$test) {
            return response()->json([
                'message' => 'Тест не найден или недоступен.'
            ], 404);
        }

        TestResult::create([
            'student_id' => $user->id,
            'test_id' => $id,
            'group_id' => $group->id
        ]);

        return response()->json($test);
    }

    private function hasUserCompletedTest($testId)
    {
        return TestResult::where('student_id', Auth::id())
            ->where('test_id', $testId)
            ->exists();
    }

}
