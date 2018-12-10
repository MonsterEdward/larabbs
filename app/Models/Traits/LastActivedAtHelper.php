<?php
namespace App\Models\Traits;

use Redis;
use Carbon\Carbon;

trait LastActivedAtHelper {
    // 缓存相关
    protected $hash_prefix = 'larabbs_last_actived_at_';
    protected $field_prefix = 'user_';

    public function recordLastActivedAt() {
        /*
        // 获取今天日期
        $date = Carbon::now()->toDateString();
        // Redis哈希表的命名
        $hash = $this->hash_prefix . $date;
        */
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());
        // 字段名称, 如user_1
        //$field = $this->field_prefix . $this->id;
        $field = $this->getHashField();
        // 当前时间
        $now = Carbon::now()->toDateTimeString();

        // 数据写入Redis, 字段已存在会更新
        Redis::hset($hash, $field, $now);
    }

    public function syncUserActivedAt() {
        /*
        // 获取昨天日期
        $yesterday_date = Carbon::yesterday()->toDateString();
        // Redis hash的命名
        $hash = $this->hash_prefix . $yesterday_date;
        */
        $hash = $this->getHashFromDateString(Carbon::yesterday()->toDateString());
        // 从Redis hash中取出所有数据
        $dates = Redis::hgetall($hash);
        // 遍历, 并同步到DB
        foreach($dates as $user_id => $actived_at) {
            // 将`user_1`转换为1
            $user_id = str_replace($this->field_prefix, '', $user_id);
            // 只有当用户存在时才更新到DB
            if($user = $this->find($user_id)) {
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }
        // 同步到DB后, 删除Redis
        Redis::del($hash);
    }

    public function getLastActivedAtAttribute($value) {
        /*
        // 获取今天的日期
        $date = Carbon::now()->toDateString();
        // Redis hash的命名
        $hash = $this->hash_prefix . $date;
        */
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());
        // 字段名称
        //$field = $this->field_prefix . $this->id;
        $field = $this->getHashField();
        // 优先选Redis中数据, 否则使用DB
        $datetime = Redis::hget($hash, $field) ?: $value;

        // 如果存在, 返回时间对应的Carbon实体
        if($datetime) {
            return new Carbon($datetime);
        }else{
            // 否则, 使用用户注册时间
            return $this->created_at;
        }
    }

    public function getHashFromDateString($date) {
        // Redis 哈希表的命名，如：larabbs_last_actived_at_2017-10-21
        return $this->hash_prefix . $date;
    }

    public function getHashField() {
        // 字段名称，如：user_1
        return $this->field_prefix . $this->id;
    }
}
