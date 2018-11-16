<?php

namespace App\Http\Controllers;

use App\Http\Requests\SessionRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    /**
     * 登录视图
     */
    public function create()
    {
        if (Auth::check()) {
           return redirect()->back()->with('warning', '您已经登录了，请勿重复操作');
        }
        return view('sessions.create');
    }

    /**
     * 登录逻辑
     * TODO:登录后返回到登录之前页面
     */
    public function store(SessionRequest $request)
    {
        if (!Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $request->input('remember'))) {
            return redirect()->back()->withErrors('邮箱和密码不匹配');
        } elseif (!Auth::user()->activated) {
            Auth::logout();
            return redirect()->back()->withErrors('您的账号未激活,请检查邮箱中的邮件进行激活');
        }
        return redirect()->intended(route('users.show', Auth::id()))->with('success', '欢迎回来');
    }

    /**
     * 登出
     */
    public function destroy()
    {
        Auth::logout();
        return redirect()->route('sessions.create')->with('success', '成功退出');
    }
}
