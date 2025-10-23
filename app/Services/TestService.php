<?php

namespace App\Services;
use App\Models\Group;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TestService
{
    public function getAvailableTestForUser(User $user, int $testId)
    {
        $currentTimestamp = Carbon::now();

        if ($this->hasUserCompletedTest($testId, $user->id))
        {
            return false;
        }

        return $user->group->tests()
            ->with([
                'gradingCriteria',
                'questions.answers' => function ($query) {
                    $query->select('id', 'question_id', 'answer_text');
                }
            ])
            ->with(['gradingCriteria' => function ($query) {
                $query->orderBy('min_correct_answers');
            }])
            ->where('tests.id', $testId)
            ->wherePivot('available_from', '<=', $currentTimestamp)
            ->wherePivot('available_until', '>=', $currentTimestamp)
            ->withPivot('id')
            ->first();
    }

    public function getAvailableTestsForUser(User $user): Collection
    {
        $currentTimestamp = Carbon::now();

        $completedTestIds = TestResult::where('student_id', $user->id)
            ->pluck('test_id');

        return $user->group->tests()
            ->wherePivot('available_from', '<=', $currentTimestamp)
            ->wherePivot('available_until', '>=', $currentTimestamp)
            ->whereNotIn('tests.id', $completedTestIds)
            ->get();
    }

    public function getCompletedTestsForUser(User $user)
    {
        return TestResult::where('student_id', $user->id)
            ->whereNotNull('grade')
            ->with(['test' => fn($q) => $q->select('id', 'title')])
            ->select('id', 'test_id', 'score', 'grade', 'completed_at', 'test_id')
            ->orderBy('completed_at', 'desc')
            ->paginate(10);
    }

    public function getTestWithDetails(User $user, int $testId): ?Test
    {
        $currentTimestamp = Carbon::now();

        return $user->group->tests()
            ->with([
                'gradingCriteria',
                'questions.answers' => function ($query) {
                    $query->select('id', 'question_id', 'answer_text');
                }
            ])
            ->with(['gradingCriteria' => function ($query) {
                $query->orderBy('min_correct_answers');
            }])
            ->where('tests.id', $testId)
            ->wherePivot('available_from', '<=', $currentTimestamp)
            ->wherePivot('available_until', '>=', $currentTimestamp)
            ->withPivot('id')
            ->first();
    }

    public function canUserAccessTest(User $user, int $testId): bool
    {
        $currentTimestamp = Carbon::now();

        return $user->group->tests()
            ->where('tests.id', $testId)
            ->wherePivot('available_from', '<=', $currentTimestamp)
            ->wherePivot('available_until', '>=', $currentTimestamp)
            ->exists();
    }

    public function getTestForDisplay(User $user, int $testId): ?Test
    {
        $currentTimestamp = Carbon::now();

        return $user->group->tests()
            ->select('tests.id', 'tests.title')
            ->where('tests.id', $testId)
            ->wherePivot('available_from', '<=', $currentTimestamp)
            ->wherePivot('available_until', '>=', $currentTimestamp)
            ->withCount('questions')
            ->with(['gradingCriteria' => function ($query) {
                $query->orderBy('min_correct_answers');
            }])
            ->first();
    }

    public function formatTestDates(Test $test): Test
    {
        $test->pivot->available_from = Carbon::parse($test->pivot->available_from)
            ->translatedFormat('d.m.Y H:i');
        $test->pivot->available_until = Carbon::parse($test->pivot->available_until)
            ->translatedFormat('d.m.Y H:i');

        return $test;
    }

    public function createTestResult(User $user, Test $test, Group $group, $testGroupId)
    {
        $testResult = TestResult::create([
                'student_id' => $user->id,
                'test_id' => $test->id,
                'group_id' => $group->id,
                'teacher_id' => $test->teacher_id,
                'test_group_id' => $testGroupId
            ]);
        return $testResult;
    }

    public function initializeTestAttempt(User $user, Test $test): Test
    {
        $testGroupId = $test->pivot->id;
        $testResult = TestResult::create([
            'student_id' => $user->id,
            'test_id' => $test->id,
            'group_id' => $user->group->id,
            'teacher_id' => $test->teacher_id,
            'test_group_id' => $testGroupId
        ]);
        $test->result_id = $testResult->id;
        return $test;
    }

    public function hasUserCompletedTest($testId, $userId)
    {
        return TestResult::where('student_id', $userId)
            ->where('test_id', $testId)
            ->exists();
    }

}
