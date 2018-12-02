<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug']; // 酌情限制$fillable中的字段

    // $topic->category
    public function category() {
    	return $this->belongsTo(Category::class);
    }

    // $topic->user
    public function user() {
    	return $this->belongsTo(User::class);
    }

    // Model Reply
    public function replies() {
        return $this->hasMany(Reply::class);
    }

    // ordered
    public function scopeWithOrder($query, $order) {
        switch ($order) {
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentReplied();
                break;
        }
        return $query->with('user', 'category'); // with()预加载
    }

    public function scopeRecentReplied($query) { // 本地作用域, https://laravel-china.org/docs/laravel/5.5/eloquent/1332#local-scopes
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query) {
        return $query->orderBy('created_at', 'desc');
    }

    public function link($params = []) {
        return route('topics.show', array_merge([$this->id, $this->slug], $params)); // $params允许附加URL参数的设定
    }

}
