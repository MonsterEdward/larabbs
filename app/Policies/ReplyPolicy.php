<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    /*public function update(User $user, Reply $reply)
    {
        // return $reply->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Reply $reply)
    {
        return true;
    }*/

    // 又拼错单词destroy, 所以RepliesController里destroy中间件不管用, blade模板里@can没起作用
    public function destroy(User $user, Reply $reply) {
    	return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
