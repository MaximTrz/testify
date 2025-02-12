<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class TestResultController extends Controller
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
            ]);

            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'message' => 'Пользователь не авторизован.'
                ], 401);
            }

            $existingResult = TestResult::where('student_id', $user->id)
                ->where('test_id', $validated['test_id'])
                ->first();

            if ($existingResult) {
                return response()->json([
                    'message' => 'Результат для этого теста уже сохранён.'
                ], 409);
            }

            $testResult = TestResult::create([
                'student_id' => $user->id,
                'test_id' => $validated['test_id'],
            ]);

            return response()->json([
                'message' => 'Результат успешно сохранён.',
                'test_result' => $testResult
            ], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(TestResult $testResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TestResult $testResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TestResult $testResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TestResult $testResult)
    {
        //
    }
}
