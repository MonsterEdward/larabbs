<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Auth;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    // 计算活跃用户trait
    use Traits\ActiveUserHelper;

    // 最后登录时间trait
    use Traits\LastActivedAtHelper;
    
    // use Notifiable;
    use Notifiable {
        notify as protected laravelNotify;
    }

    // permission;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics() { // User关联Topic
        return $this->hasMany(Topic::class); // 可用$user->topics获取用户发布的所有话题
    }

    public function replies() {
        return $this->hasMany(Reply::class);
    }

    public function isAuthorOf($model) {
        return $this->id == $model->user_id;
    }

    public function notify($instance) {
        if($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    public function markAsRead() {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    // https://laravel-china.org/docs/laravel/5.5/eloquent-mutators/1335
    public function setPasswordAttribute($value) {
        // 如果长度=60, 即认为是已做过加密
        if(strlen($value) != 60) {
            // !=60, 做密码加密处理
            $value = bcrypt($value);
        }

        //$this->attributes['password'] = bcrypt($value);
        $this->attributes['password'] = $value; // 粗心
    }

    public function setAvatarAttribute($path) {
        // 如果不是`http`开头, 就是从admin后台传上去的, 需补全url. 忘了怎么处理的...
        if(! starts_with($path, 'http')) {
            // 拼接完整的url
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }
        $this->attributes['avatar'] = $path;
    }
}
