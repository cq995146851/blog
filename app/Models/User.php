<?php

namespace App\Models;

use function foo\func;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 监听钩子函数
     */
    public static function boot()
    {
        parent::boot();

        //模型初始化时触发
        static::creating(function($user) {
            $user->activation_token = str_random(32);
        });
    }

    /**
     * 获取所有的文章
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id', 'id');
    }

}
