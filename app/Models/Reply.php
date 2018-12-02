<?php

namespace App\Models;

// 话题骨架, 源码? 作用原理?!

class Reply extends Model
{
    protected $fillable = ['content'];

    public function topic() {
        return $this->belongsTo(Topic::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
