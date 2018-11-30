<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest; // 表单验证类

use App\Models\Category;
use Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
		// 限制未登录用户发帖, 对除了index(), show()外的方法使用auth中间件认证
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic)
	{
		 //$topics = Topic::paginate(30);
		// https://laravel-china.org/docs/laravel/5.4/eloquent-relationships/1265#eager-loading
		//$topics = Topic::with('user', 'category')->paginate(30); //使用with()预加载关联属性user和category, 并做了缓存
		$topics = $topic->withOrder($request->order)->paginate(20); //使用了Topic模型中的本地作用域
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
		$categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function store(TopicRequest $request, Topic $topic) // 注入TopicRequest表单验证类
	{
		//$topic = Topic::create($request->all());
		$topic->fill($request->all());
		$topic->user_id = Auth::id();
		$topic->save();

		//return redirect()->route('topics.show', $topic->id)->with('message', 'Created successfully.');
		return redirect()->route('topics.show', $topic->id)->with('message', 'Created successfully.');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}
}