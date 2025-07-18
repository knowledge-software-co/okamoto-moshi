<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\Models\User\RoleType;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
    * 事前認可チェックの実行
    */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasAnyRole([RoleType::SYSTEM_ADMIN, RoleType::ADMIN])) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([RoleType::SYSTEM_ADMIN, RoleType::ADMIN, RoleType::MEMBER]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $requestUser): bool
    {
        return $user->hasAnyRole([RoleType::SYSTEM_ADMIN, RoleType::ADMIN, RoleType::MEMBER]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, User $requestUser): bool
    {
        return $user->hasAnyRole([RoleType::SYSTEM_ADMIN, RoleType::ADMIN, RoleType::MEMBER]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $requestUser): bool
    {
        return $user->hasAnyRole([RoleType::SYSTEM_ADMIN, RoleType::ADMIN, RoleType::MEMBER]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $requestUser): bool
    {
        return $user->hasAnyRole([RoleType::SYSTEM_ADMIN, RoleType::ADMIN, RoleType::MEMBER]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $requestUser): bool
    {
        return $user->hasAnyRole([RoleType::SYSTEM_ADMIN, RoleType::ADMIN, RoleType::MEMBER]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $requestUser): bool
    {
        return $user->hasAnyRole([RoleType::SYSTEM_ADMIN, RoleType::ADMIN, RoleType::MEMBER]);
    }
}
