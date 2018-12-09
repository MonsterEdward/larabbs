<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest; // 表单验证类

use App\Models\Category;
use Auth;
use App\Handlers\ImageUploadHandler;
use App\Models\User;

class TopicsController extends Controller
{
    public function __construct()
    {
		// 限制未登录用户发帖, 对除了index(), show()外的方法使用auth中间件认证
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic, User $user)
	{
		 //$topics = Topic::paginate(30);
		// https://laravel-china.org/docs/laravel/5.4/eloquent-relationships/1265#eager-loading
		//$topics = Topic::with('user', 'category')->paginate(30); //使用with()预加载关联属性user和category, 并做了缓存
		$topics = $topic->withOrder($request->order)->paginate(20); //使用了Topic模型中的本地作用域

		$active_users = $user->getActiveUsers();
		return view('topics.index', compact('topics', 'active_users')); // 不知道传active_users数据到blade
	}

    public function show(Request $request, Topic $topic)
    {
		// URL 301强制跳转
		if(! empty($topic->slug) && $topic->slug != $request->slug) {
			return redirect($topic->link(), 301);
		}
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
		//return redirect()->route('topics.show', $topic->id)->with('success', 'Created successfully.');
        return redirect()->to($topic->link())->with('success', '成功创建话题！');
	}

	public function edit(Topic $topic)
	{
		// policy使用机制? 无需引入命名空间?!
		$this->authorize('update', $topic); // TopicPolicy限制, 当话题关联作者id与登录者id一致才放行
		$categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		//return redirect()->route('topics.show', $topic->id)->with('success', 'Updated successfully.');
        return redirect()->to($topic->link())->with('success', '成功修改话题！');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic); // TopicPolicy使用?
		$topic->delete();

		return redirect()->route('topics.index')->with('success', 'Deleted successfully.');
	}

	// 与图像上传使用的是同一个ImageUploadHandler
	public function uploadImage(Request $request, ImageUploadHandler $uploader) { // simditor上传文档, https://simditor.tower.im/docs/doc-config.html#anchor-upload
		$data = [
			'success' => false,
			'msg' => '上传失败',
			'file_path' => ''
		];

		if($file = $request->upload_file) {
			$result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);

			if($result) {
				$data['file_path'] = $result['path'];
				$data['msg'] = '上传成功';
				$data['success'] = true;
			}
		}

		return $data;
	}
}