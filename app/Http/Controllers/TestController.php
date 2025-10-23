<?php

namespace App\Http\Controllers;
use App\Models\TestResult;
use App\MoonShine\Resources\TestResultResource;
use App\Services\TestService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller{

    protected $testService;

    public function __construct(TestService $testService)
    {
        $this->middleware('auth');
        $this->testService = $testService;
    }

    public function index()
    {
        $tests = $this->testService->getAvailableTestsForUser(Auth::user());
        return view('tests.inwork', compact('tests'));
    }


    public function completed()
    {
        $results = $this->testService->getCompletedTestsForUser(Auth::user());
        return view('tests.completed', compact('results'));
    }

    public function show($id)   {

        if ($this->testService->hasUserCompletedTest(Auth::user(), $id))
        {
            abort(403, 'Вы уже выполняли этот тест или тест недоступен.');
        }

        $test = $this->testService->getTestForDisplay(Auth::user(), $id);

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

        if ($this->testService->hasUserCompletedTest($user, $id)) {
            return response()->json([
                'message' => 'Вы уже выполняли этот тест.'
            ], 403);
        }

        $test = $this->testService->getTestWithDetails($user, $id);

        if (!$test) {
            return response()->json([
                'message' => 'Тест не найден или недоступен.'
            ], 404);
        }

        $test = $this->testService->initializeTestAttempt($user, $test);

        return response()->json($test);

    }

}
