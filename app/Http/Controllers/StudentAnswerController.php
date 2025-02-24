<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\GradingCriteria;
use App\Models\StudentAnswer;
use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Services\TestResultService;

class StudentAnswerController extends Controller
{


    public function __construct(TestResultService $testResultService)
    {
        $this->testResultService = $testResultService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'test_id' => 'required|exists:tests,id',
            'question_id' => 'required|exists:questions,id',
            'answer_id' => 'required|exists:answers,id',
            'last_answer' => 'required|boolean'
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Пользователь не авторизован.'
            ], 401);
        }

        $answer = Answer::find($validated['answer_id']);

        $studentAnswer = StudentAnswer::create([
            'student_id' => $user->id,
            'test_id' => $validated['test_id'],
            'question_id' => $validated['question_id'],
            'answer_id' =>  $validated['answer_id'],
            'is_correct' => $answer->is_correct
        ]);

        //Log::debug('last_answer value', ['last_answer' => $validated['last_answer']]);

        if ($validated['last_answer'] == 1) {

            try {
                $testResult = $this->testResultService->calculateAndSaveTestResult($validated['test_id'], $user->id);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 400);
            }

        }

        return response()->json([
            'message' => 'Ответ успешно сохранен',
            'result' => $studentAnswer,
            'last_answer' => $validated['last_answer']
        ], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(StudentAnswer $studentAnswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentAnswer $studentAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentAnswer $studentAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentAnswer $studentAnswer)
    {
        //
    }
}
