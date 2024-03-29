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
    // 第一个参数默认为当前登录用户实例，第二个参数则为要进行授权的用户实例。当两个 id 相同时，
    // 则代表两个用户是相同用户，用户通过授权，可以接着进行下一个操作。如果 id 不相同的话
    public function update(User $currentUser,User $user){
        return $currentUser->id === $user->id;
    }

    public function destroy(User $currentUser,User $user){
        //  下面这行代码指明，只有当前用户拥有管理员权限且删除的用户不是自己时才显示链接。
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }

}
