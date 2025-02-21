<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\StudentAnswer;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StudentAnswerController extends Controller
{
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

        if ($validated['last_answer']==1){

            $testResult = TestResult::where('test_id', $validated['test_id'])
                ->where('student_id', $user->id)
                ->first();

            $correctAnswersCount = StudentAnswer::where('student_id', $user->id)
                ->where('test_id', $validated['test_id'])
                ->where('is_correct', 1)
                ->count();

            $testResult->update([
                'score' => $correctAnswersCount,
            ]);

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
