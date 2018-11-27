<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use App\HTTP\Requests\UserRequest;

use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function show(User $user) {
        return view('users.show', compact('user'));
    }

    public function edit(User $user) {
		$this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user) {//不使用validator而使用FormRequest
        $this->authorize('update', $user);
		//获取上传文件信息 $request->file('avatar')或$request->avatar
        $data = $request->all();

        if($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatar', $user->id, 361);
            if($request) {
                $data['avatar'] = $result['path'];
            }
        }

        //$user->update($request->all());
        $user->update($data);

        return redirect()->route('users.show', $user->id)->with('success', 'Update your info success');

    }
}
