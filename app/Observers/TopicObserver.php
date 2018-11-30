<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    /*public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }*/

    // https://laravel-china.org/docs/laravel/5.5/eloquent/1332#observers
    public function saving(Topic $topic) { // 观察器, 已在AppServiceProvider中注册
        // make_excerpt()是自定义的辅助方法, 需在helpers.php添加
        $topic->body = clean($topic->body, 'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body);
    }
}