<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.login');
    }

    /**
     *添加评论逻辑
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'content' => 'required|between:3,100'
        ],[
            'content.required' => '内容不能为空',
            'content.between' => '内容长度必须在3到100个'
        ]);
        $article = Article::find($request->input('article_id'));
        //判断是否评论过
        $is_new = $article->hasComment(Auth::id()) ? false : true;
        $article->addComment($request->input('content'), $is_new);
        return redirect()->back()->with('success', '发表评论成功');
    }

    /**
     * 删除评论逻辑
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', '删除评论成功');
    }
}
