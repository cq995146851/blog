<?php

namespace App\Http\Controllers;

use App\Handler\Email;
use App\Http\Requests\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * 发送重置邮件表单
     */
    public function create()
    {
        return view('password.create');
    }

    /**
     * 发送重置邮件逻辑
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'email' => 'required|email',
           'captcha' => 'required|captcha'
        ],[
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '验证码不正确'
        ]);
        $token = md5(uniqid() . time());
        session()->put('reset_password_token', $token);
        $email = $request->input('email');
        $emailData = [
            'view' => 'email.reset_pwd',
            'data' => compact('token', 'email'),
            'to' => $email,
            'subject' => '星期八博客密码找回邮件'
        ];
        Email::sendUserConfirm($emailData);
        return redirect()->back()->with('warning', '密码找回确认链接已经发送到你的邮箱，请注意查收');
    }

    /**
     * @param $token 重置密码令牌
     * @param $email 重置密码邮箱
     */
    public function confirmResetPassword($token, $email)
    {
        $sToken = session()->get('reset_password_token');
        if ($token != $sToken) {
            return redirect()->route('password.create')->with('danger', '链接已经失效,请重新获取');
        }
        return view('password.reset', compact('email'));
    }

    /**
     * 密码重置逻辑
     */
    public function save(PasswordReset $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('password'), $user->password)) {
            return redirect()->back()->withErrors('新密码不能与旧密码相同');
        }
        $user->password = bcrypt($request->input('password'));
        $user->save();
        session()->forget('reset_password_token');
        return redirect()->route('sessions.create')->with('success', '新密码重置成功');
    }

}
