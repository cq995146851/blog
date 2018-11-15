<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param User $currUser
     * @param User $user
     * @return bool
     * 修改权限
     */
    public function update(User $currUser, User $user)
    {
        return $currUser->id === $user->id;
    }

    /**
     * @param User $currUser
     * @param User $user
     * @return bool
     * 删除
     */
    public function delete(User $currUser, User $user)
    {
        return $currUser->id === $user->id || $currUser->is_admin;
    }
}
