<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    /*public function __construct()
    {
        //
    }*/

    public function before($user, $ability)
	{
        // https://laravel-china.org/docs/laravel/5.5/authorization/1310#policy-filters
        // 如果用户拥有管理内容的权限, 即授权通过
	    if ($user->can('manage_contents')) { // 又拼错单词!
	    		return true;
	    }
	}
}
