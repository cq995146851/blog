<?php

namespace App\Http\Controllers;

use App\Handler\ImageUpload;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Handler\Email;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.login', [
           'except' => ['create', 'store', 'confirmCreate']
        ]);
    }

    /**
     * 注册视图
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * 注册逻辑
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

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user, ImageUpload $upload)
    {
        $this->validate($request, [
           'name' => 'required|unique:users,email,' . $user->id
        ], [
            'name.required' => '用户名不能为空',
            'name.unique' => '用户名已经存在'
        ]);
        $user->name = $request->input('name');
        if($request->file('avatar')){
            $image = $upload->save($request->file('avatar'), 'avatar', $user->id, '320');
            $user->avatar = $image['path'];
        }
        $user->save();
        return redirect()->route('home')->with('success', '修改资料成功');
    }

    public function createResetPassword()
    {
        return view('users.password_reset');
    }

    public function storeResetPassword(Request $request)
    {
        $user = User::find(Auth::id());
        $this->validate($request, [
            'old_password' => 'required|between:6,20',
            'password' => 'required|between:6,20|confirmed',
            'captcha' => 'required|captcha'
        ],[
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
        return redirect()->route('home')->with('success', '密码修改成功');
    }

    //注册激活
    public function confirmCreate($token)
    {
        $user = User::where('activation_token', $token)->first();
        $user->activation_token = null;
        $user->activated = true;
        $user->save();
        Auth::login($user);
        return redirect()->route('home')->with('success', '邮箱激活成功');
    }
}
