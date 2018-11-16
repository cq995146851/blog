<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        static::creating(function ($user) {
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

    /**
     * 获取粉丝
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id')
            ->withPivot('user_id', 'follower_id')
            ->withTimestamps();
    }

    /**
     * 获取关注的人
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id')
            ->withPivot('user_id', 'follower_id')
            ->withTimestamps();
    }

    /**
     * 判断是否关注某人
     */
    public function isFollowing($user_id)
    {
        return $this->followings()->find($user_id);
    }

    /**
     * 判断是否被某人关注
     */

    public function isFollower($user_id)
    {
        return $this->followers()->find($user_id);
    }

    /**
     * 关注某人
     */
    public function follow($user_ids)
    {
        return $this->followings()->sync($user_ids, false);
    }

    /**
     * 取消关注
     */

    public function unfollow($user_ids)
    {
        return $this->followings()->detach($user_ids);
    }

    /**
     * 获取粉丝或关注者列表
     */
    public function getFollowData($type)
    {
        switch ($type) {
            case 'followings':
                $users = $this->followings();
                break;
            default:
                $users = $this->followers();
                break;
        }
        return $users->withCount('followers')->paginate(10);
    }
}
