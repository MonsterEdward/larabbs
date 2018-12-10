<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Topic;
use App\Models\Category;

use App\Models\User;
use App\Models\Link;

class CategoriesController extends Controller
{
    public function show(Category $category, Request $request, Topic $topic, User $user, Link $link) {
        //$topics = Topic::where('category_id', $category->id)->paginate(20);
        $topics = $topic->withOrder($request->order)->where('category_id', $category->id)->paginate(20);
        
        // 活跃用户列表
        $active_users = $user->getActiveUsers();

        // 资源链接
        $links = $link->getAllCached();

        // 传参到blade中
        return view('topics.index', compact('topics', 'category', 'active_users', 'links')); // 不明白compact()的意思, 向blade中传参, 少加了个字母s, 其实也分不清blade中的变量是由哪个controller传进去的
    }
}
