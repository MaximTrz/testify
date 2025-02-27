<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\StudentAnswer;
use MoonShine\Laravel\Models\MoonshineUser;

class StudentAnswerPolicy
{
    use HandlesAuthorization;

    public function viewAny(MoonshineUser $user): bool
    {
        return true;
    }

    public function view(MoonshineUser $user, StudentAnswer $item): bool
    {
        return false;
    }

    public function create(MoonshineUser $user): bool
    {
        return false;
    }

    public function update(MoonshineUser $user, StudentAnswer $item): bool
    {
        return false;
    }

    public function delete(MoonshineUser $user, StudentAnswer $item): bool
    {
        return false;
    }

    public function restore(MoonshineUser $user, StudentAnswer $item): bool
    {
        return true;
    }

    public function forceDelete(MoonshineUser $user, StudentAnswer $item): bool
    {
        return true;
    }

    public function massDelete(MoonshineUser $user): bool
    {
        return false;
    }
}
