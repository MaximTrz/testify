<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestResultRequest;

use App\Services\TestResultService;

use Illuminate\Support\Facades\Auth;

class TestResultController extends Controller
{
    public function __construct(TestResultService $testResultService)
    {
        $this->testResultService = $testResultService;
    }
    public function store(TestResultRequest $request)    {

        $user = Auth::user();
        $group = $user->group;

        if ($this->testResultService
            ->isExistingResult($request['test_id'], $user->id)) {
            return response()->json([
                'message' => 'Результат для этого теста уже сохранён.'
            ], 409);
        }

        $testResult = $this->testResultService->createTestResult(
            $request['test_id'],
            $user->id,
            $group->id,
        );

        return response()->json([
            'message' => 'Результат успешно сохранён.',
            'test_result' => $testResult
        ], 201);

    }

    public function update(TestResultRequest $request)
    {

        $user = Auth::user();

        if (!$this->testResultService
            ->isExistingResult($request['test_id'], $user->id))  {
            return response()->json([
                'message' => 'Результат теста не найден.'
            ], 404);
        }


        try {
            $testResult = $this->testResultService->calculateAndSaveTestResult($request['test_id'], $user->id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

        return response()->json([
            'message' => 'Результат успешно обновлён.',
            'test_result' => $testResult
        ], 200);
    }

}
