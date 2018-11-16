<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
     * 文章对应话题
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'id');
    }

    /**
     *所有评论
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id', 'id');
    }

    /**
     * 根据user_id获取文章
     */
    public static function getArticlesByUserId($user_id)
    {
        return self::where('user_id', $user_id)
            ->with('user')
            ->withCount(['zans', 'comments'])
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

    /**
     * 文章列表排序
     */
    public function scopeOrder($query, $order)
    {
        switch ($order) {
            case 'new':
                $query = $query->orderBy('created_at', 'desc');
                break;
            case 'hot':
                $query = $query->orderBy('id', 'asc');
                break;
        }
        return $query->with('user')->withCount(['zans', 'comments']);
    }

    /**
     * 根据话题筛选
     */
    public function scopeByTopic($query, $topic_id)
    {
        return $query->where('topic_id', $topic_id)
            ->with('user')
            ->withCount(['zans', 'comments']);
    }

    /**
     * 添加评论
     */
    public function addComment($content, $is_new = true)
    {
        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->is_new = $is_new;
        $comment->content = $content;
        return $this->comments()->save($comment);
    }

    /**
     * 文章是否有某个人的评论
     */
    public function hasComment($user_id)
    {
        return $this->comments()->where('user_id', $user_id)->first();
    }
}
