<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Group;
use MoonShine\Laravel\Models\MoonshineUser;

class GroupPolicy
{
    use HandlesAuthorization;

    public function checkSuperUser($user){
        if ($user->isSuperUser()){
            return true;
        }
        return false;
    }

    public function viewAny(MoonshineUser $user): bool
    {
        return true;
    }

    public function view(MoonshineUser $user, Group $item): bool
    {
        return true;
    }

    public function create(MoonshineUser $user): bool
    {
        return $this->checkSuperUser($user);
    }

    public function update(MoonshineUser $user, Group $item): bool
    {
        return $this->checkSuperUser($user);
    }

    public function delete(MoonshineUser $user, Group $item): bool
    {
        return $this->checkSuperUser($user);
    }

    public function restore(MoonshineUser $user, Group $item): bool
    {
        return $this->checkSuperUser($user);
    }

    public function forceDelete(MoonshineUser $user, Group $item): bool
    {
        return $this->checkSuperUser($user);
    }

    public function massDelete(MoonshineUser $user): bool
    {
        return $this->checkSuperUser($user);
    }
}
