<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Cache;

/*
php artisan make:model Models/Link -m // 生成迁移文件
php artisan migrate // 使用生成的迁移文件create table

php artisan make:factory LinkFactory // 生成数据工厂文件
php artisan make:seeder LinksTableSeeder // 生成假数据填充文件. 之后需将生成的假数据填充文件注册到DatabaseSeeder

php artisan migrate:refresh --seed // 刷新数据库, 然后重新生成数据

*/

class Link extends Model
{
    protected $fillable = ['title', 'link'];

    public $cache_key = 'larabbs_links';
    protected $cache_expire_in_minutes = 1440;

    public function getAllCached() {
        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出 links 表中所有的数据，返回的同时做了缓存。
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function() {
            return $this->all();
        });
    }
}
