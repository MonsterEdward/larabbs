<?php

namespace App\Observers;

use App\Models\Topic;
//use App\Handlers\SlugTranslateHandler;

use App\Jobs\TranslateSlug; // 换为队列

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
        $topic->body = clean($topic->body, 'user_topic_body'); // clean() XSS过滤

        // 生成话题列表
        $topic->excerpt = make_excerpt($topic->body);

        /*
        if(! $topic->slug) {
            //$topic->slug = app(SlugTranslateHandler::class)->translate($topic->title); // app(), 使用服务容器. https://laravel-china.org/docs/laravel/5.5/container/1289

            dispatch(new TranslateSlug($topic)); // 此时分发队列, Topic模型中id为null, 所以无法执行队列
        }*/
    }

    // https://laravel-china.org/courses/laravel-intermediate-training/5.5/using-queues/663
    public function saved(Topic $topic) {
        // 若slug字段无内容, 即使用翻译器对title进行翻译
        if (! $topic->slug) {
            dispatch(new TranslateSlug($topic));
        }
    }
}