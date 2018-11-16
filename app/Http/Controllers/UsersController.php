<?php

namespace App\Http\Controllers;

use App\Handler\ImageUpload;
use App\Http\Requests\UserRequest;
use App\Models\Article;
use App\Models\User;
use App\Handler\Email;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     *检验登录状态
     */
    public function __construct()
    {
        $this->middleware('check.login', [
            'except' => ['create', 'store', 'confirmCreate', 'index', 'show']
        ]);
    }

    /**
     * 用户列表
     */
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $type = $request->input('type');
        if ($user_id && $type) {
            $users = User::find($user_id)->getFollowData($type);
        } else {
            $users = User::withCount('followers')
                ->orderBy('followers_count', 'desc')
                ->paginate(10);
        }
        return view('users.index', compact('users'));
    }

    /**
     * @param User $user
     * 个人中心
     */
    public function show(User $user)
    {
        $user = User::withCount(['articles', 'followings', 'followers'])
            ->find($user->id);
        $articles = Article::getArticlesByUserId($user->id);
        return view('users.show', compact('user', 'articles'));
    }

    /**
     * 用户注册视图
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * 用户注册逻辑
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        $emailData = [
            'view' => 'email.user_confirm',
            'data' => compact('user'),
            'to' => $user->email,
            'subject' => '感谢注册 星期八 博客！请确认你的邮箱'
        ];
        Email::sendUserConfirm($emailData);
        return redirect()->back()->with('warning', '激活邮箱已经发送到你的邮箱，请注意查收');
    }

    /**
     * @param User $user
     * 资料编辑视图
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * @param Request $request
     * @param User $user
     * @param ImageUpload $upload 自定义图片上传类
     * 用户资料编辑逻辑
     */
    public function update(Request $request, User $user, ImageUpload $upload)
    {
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|unique:users,email,' . $user->id,
            'avatar' => 'image'
        ], [
            'name.required' => '用户名不能为空',
            'name.unique' => '用户名已经存在',
            'avatar.image' => '上传的文件必须是图片'
        ]);
        $user->name = $request->input('name');
        if ($request->file('avatar')) {
            $image = $upload->save($request->file('avatar'), 'avatar', $user->id, '320');
            $user->avatar = $image['path'];
        }
        $user->save();
        return redirect()->route('users.show', $user->id)->with('success', '修改资料成功');
    }

    /**
     *密码修改视图
     */
    public function createResetPassword()
    {
        return view('users.password_reset');
    }

    /**
     * 密码修改逻辑
     */
    public function storeResetPassword(Request $request)
    {
        $user = User::find(Auth::id());
        $this->validate($request, [
            'old_password' => 'required|between:6,20',
            'password' => 'required|between:6,20|confirmed',
            'captcha' => 'required|captcha'
        ], [
            'old_password.required' => '旧密码不能为空',
            'old_password.between' => '旧密码只能在6到20位',
            'password.required' => '新密码不能为空',
            'password.between' => '新密码只能在6到20位',
            'password.confirmed' => '两次密码不一致',
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '验证码不正确'
        ]);
        if (!Hash::check($request->input('old_password'), $user->password)) {
            return redirect()->back()->withErrors('旧密码不正确');
        }
        $user->password = bcrypt($request->input('password'));
        $user->save();
        Auth::logout();
        return redirect()->route('sessions.create')->with('success', '密码修改成功,请重新登录');
    }

    /**
     * @param $token 邮件令牌
     * 用户注册邮件激活
     */
    public function confirmCreate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return redirect()->route('sessions.create')->with('warning', '邮箱已经失效或已经激活成功，请重新激活或发送');
        }
        $user->activation_token = null;
        $user->activated = true;
        $user->save();
        Auth::login($user);
        return redirect()->route('users.show', $user->id)->with('success', '邮箱激活成功');
    }

    /**
     * 关注与取消关注逻辑
     */
    public function follow(Request $request)
    {
        if (!Auth::check()) {
            return [
                'errcode' => 1,
                'errmsg' => '您尚未登录，请登录后再关注',
            ];
        }
        $this->validate($request, [
            'status' => 'required|boolean',
            'user_id' => 'required|integer'
        ], [
            'status.required' => '缺少状态值参数',
            'status.boolean' => '状态值参数必须是布尔值',
            'user_id.required' => '缺少用户编号参数',
            'user_id.integer' => '用户编号参数必须是整数'
        ]);

        if ($request->input('status')) {
            Auth::user()->follow($request->input('user_id'));
            $msg = '关注成功';
        } else {
            Auth::user()->unfollow($request->input('user_id'));
            $msg = '取消关注成功';
        }

        return [
            'errcode' => 0,
            'msg' => $msg
        ];
    }
}
