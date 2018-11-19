<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    /*
     * 评论所属用户
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * 获取所有顶
     */
    public function zans()
    {
        return $this->hasMany(CommentZan::class, 'comment_id', 'id');
    }

    /**
     * 根据article_id获取评论
     */
    public static function getByArticleId($article_id)
    {
        return self::where('article_id', $article_id)
            ->withCount('zans')
            ->orderBy('zans_count', 'desc')
            ->paginate(5);
    }

    /**
     * 判断是否顶过
     */
    public function isZan($user_id)
    {
        return $this->zans()->where('user_id', $user_id)->first();
    }

    /**
     * 顶
     */
    public function dozan()
    {
        $comment_zan = new CommentZan();
        $comment_zan->user_id = Auth::id();
        return $this->zans()->save($comment_zan);
    }
}
