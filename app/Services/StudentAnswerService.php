<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\StudentAnswer;

class StudentAnswerService
{
    public function getStudentAnswer(int $studentAnswerId): Answer
    {
        return Answer::find($studentAnswerId);
    }

    public function createStudentAnswer(
        int $studentId,
        int $testId,
        int $questionId,
        int $answerId,
        bool $isCorrect,
        int $testResultId
    ): StudentAnswer
    {
        return StudentAnswer::create([
            'student_id' => $studentId,
            'test_id' => $testId,
            'question_id' => $questionId,
            'answer_id' => $answerId,
            'is_correct' => $isCorrect,
            'test_result_id' => $testResultId,
        ]);
    }





}
