<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentAnswerRequest;
use App\Services\StudentAnswerService;
use Illuminate\Support\Facades\Auth;
use App\Services\TestResultService;

class StudentAnswerController extends Controller
{
    public function __construct(TestResultService $testResultService,
                                StudentAnswerService $studentAnswerService)
    {
        $this->testResultService = $testResultService;
        $this->studentAnswerService = $studentAnswerService;
    }

    public function store(StudentAnswerRequest $request)
    {

        $user = Auth::user();
        $validated = $request->validated();

        try {
            $answer = $this->studentAnswerService->getStudentAnswer($validated['answer_id']);

            $studentAnswer = $this->studentAnswerService->createStudentAnswer(
                $user->id,
                $validated['test_id'],
                $validated['question_id'],
                $validated['answer_id'],
                $answer->is_correct,
                $validated['result_id'],
            );

            $lastAnswerProcessed = $this->testResultService->handleLastAnswer($validated, $user->id);

            return response()->json([
                'message' => 'Ответ успешно сохранен',
                'result' => $studentAnswer,
                'last_answer_processed' => $lastAnswerProcessed
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ошибка при сохранении ответа: ' . $e->getMessage()
            ], 400);
        }

    }

}
