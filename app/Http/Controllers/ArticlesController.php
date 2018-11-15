<?php

namespace App\Http\Controllers;

use App\Handler\ImageUpload;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{
    /**
     * 权限控制
     */
    public function __construct()
    {
        $this->middleware('check.login', [
            'except' => ['index', 'show']
        ]);
    }

    /**
     * 文章列表
     */
    public function index()
    {
        $articles = Article::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('articles.index', compact('articles'));
    }

    /**
     * 文章详情
     */
    public function show(Article $article)
    {
        $articel = Article::with('user')
            ->orderBy('created_at', 'desc')
            ->find($article->id);
        return view('articles.show', compact('article'));
    }

    /**
     * 添加文章视图
     */
    public function create(Article $article)
    {
        $topics = Topic::all();
        return view('articles.create_and_edit', compact('topics', 'article'));
    }

    /**
     *添加文章逻辑
     */
    public function store(ArticleRequest $request)
    {
        $article = new Article();
        $article->title = $request->input('title');
        $article->topic_id = $request->input('topic_id');
        $article->content = $request->input('content');
        $article->user_id = Auth::id();
        $article->save();
        return redirect()->route('users.show', Auth::id())->with('success', '帖子添加成功');
    }

    /**
     * 修改视图
     */
    public function edit(Article $article)
    {
        $topics = Topic::all();
        return view('articles.create_and_edit', compact('topics', 'article'));
    }

    /**
     * 修改逻辑
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $article->title = $request->input('title');
        $article->topic_id = $request->input('topic_id');
        $article->content = $request->input('content');
        $article->user_id = Auth::id();
        $article->save();
        return redirect()->route('users.show', Auth::id())->with('success', '帖子修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * 删除逻辑
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('users.show', Auth::id())->with('success', '帖子删除成功');
    }

    /**
     * 上传图片
     */
    public function uploadImg(Request $request, ImageUpload $upload)
    {
        $data = [
            'success' => false,
            'msg' => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->file('upload_file')) {
        // 保存图片到本地
            $result = $upload->save($request->file('upload_file'), 'articles', Auth::id(), 100);
        // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg'] = "上传成功!";
                $data['success'] = true;
            }
        }
        return $data;
    }
}
