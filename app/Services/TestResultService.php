<?php

namespace App\Services;

use App\Models\GradingCriteria;
use App\Models\StudentAnswer;
use App\Models\TestResult;
use Exception;

class TestResultService
{
    public function isExistingResult(int $testId, int $studentId):boolean
    {
        return TestResult::where('test_id', $testId)
            ->where('student_id', $studentId)
            ->exists();
    }

    public function createTestResult(int $testId, int $studentId, int $groupId): TestResult
    {
        $testResult = TestResult::create([
            'student_id' => $studentId,
            'test_id' => $testId,
            'group_id' => $groupId
        ]);
        return $testResult;
    }

    public function handleLastAnswer(array $data, int $user_id): void
    {
        if ($data['last_answer'] == 1) {
            $this->calculateAndSaveTestResult($data['test_id'], $user_id);
        }
    }

    public function calculateAndSaveTestResult(int $testId, int $studentId): TestResult
    {
        $gradingCriteria = GradingCriteria::where('test_id', $testId)->get();

        $studentGrade = null;
        $correctAnswersCount = StudentAnswer::where('student_id', $studentId)
            ->where('test_id', $testId)
            ->where('is_correct', 1)
            ->count();

        if (!($gradingCriteria->isEmpty()) ) {

            $studentGrade = 2;

            if ($correctAnswersCount > 0) {
                $maxCorrect = $gradingCriteria->max('max_correct_answers');

                if ($correctAnswersCount >= $maxCorrect) {
                    $studentGrade = 5;
                } else {
                    $gradingCriteria = $gradingCriteria->sortBy('min_correct_answers');

                    foreach ($gradingCriteria as $criteria) {
                        if (
                            $correctAnswersCount >= $criteria->min_correct_answers &&
                            $correctAnswersCount <= $criteria->max_correct_answers
                        ) {
                            $studentGrade = $criteria->grade;
                            break;
                        }
                    }
                }
            }

        }

        $testResult = TestResult::updateOrCreate(
            ['test_id' => $testId, 'student_id' => $studentId],
            ['score' => $correctAnswersCount, 'grade' => $studentGrade]
        );

        return $testResult;
    }
}
