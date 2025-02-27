<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\TestResult;
use MoonShine\Laravel\Models\MoonshineUser;

class TestResultPolicy
{
    use HandlesAuthorization;

    public function viewAny(MoonshineUser $user): bool
    {
        return true;
    }

    public function view(MoonshineUser $user, TestResult $item): bool
    {
        return true;
    }

    public function create(MoonshineUser $user): bool
    {
        return false;
    }

    public function update(MoonshineUser $user, TestResult $item): bool
    {
        return false;
    }

    public function delete(MoonshineUser $user, TestResult $item): bool
    {
        return true;
    }

    public function restore(MoonshineUser $user, TestResult $item): bool
    {
        return true;
    }

    public function forceDelete(MoonshineUser $user, TestResult $item): bool
    {
        return true;
    }

    public function massDelete(MoonshineUser $user): bool
    {
        return true;
    }
}
