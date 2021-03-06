<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;

use Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('auth');
    }

	/*
	public function index()
	{
		$replies = Reply::paginate();
		return view('replies.index', compact('replies'));
	}

    public function show(Reply $reply)
    {
        return view('replies.show', compact('reply'));
    }

	public function create(Reply $reply)
	{
		return view('replies.create_and_edit', compact('reply'));
	}
	*/

	public function store(ReplyRequest $request, Reply $reply)
	{
		//$reply = Reply::create($request->all());
		$reply->content = $request->content;
		$reply->user_id = Auth::id();
		$reply->topic_id = $request->topic_id;
		$reply->save();

		//return redirect()->route('replies.show', $reply->id)->with('message', 'Created successfully.');
		return redirect()->to($reply->topic->link())->with('success', '创建成功');
	}

	/*
	public function edit(Reply $reply)
	{
        $this->authorize('update', $reply);
		return view('replies.create_and_edit', compact('reply'));
	}

	public function update(ReplyRequest $request, Reply $reply)
	{
		$this->authorize('update', $reply);
		$reply->update($request->all());

		return redirect()->route('replies.show', $reply->id)->with('message', 'Updated successfully.');
	}
	*/

	public function destroy(Reply $reply)
	{
		$this->authorize('destroy', $reply);
		$reply->delete();

		// 为什么总是临摹? 不能自己动手写一些玩意跑跑吗? 不动脑? 光看不练, 就能学会游泳了?
		//return redirect()->route('replies.index')->with('message', '删除成功!'/*'Deleted successfully.'*/);
		return redirect()->to($reply->topic->link())-with('success', '成功删除回复!');
	}
}