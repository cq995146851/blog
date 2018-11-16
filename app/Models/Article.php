<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * 文章对应用户
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * 根据user_id获取文章
     */
    public static function getArticlesByUserId($user_id)
    {
        return self::where('user_id', $user_id)
            ->with('user')
            ->withCount('zans')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    /**
     *所有赞
     */
    public function zans()
    {
        return $this->belongsToMany(User::class, 'zans', 'article_id', 'user_id');
    }

    /**
     * 判断是否点了赞
     */
    public function isZan($user_id)
    {
        return $this->zans->find($user_id);
    }

    /**
     * 点赞
     */
    public function dozan($user_ids)
    {
        return $this->zans()->sync($user_ids);
    }

    /**
     *取消赞
     */
    public function unzan($user_ids)
    {
        return $this->zans()->detach($user_ids);
    }
}
