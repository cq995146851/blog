<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|between:2,20|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|between:6,20|confirmed',
            'captcha' => 'required|captcha'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '用户名不能为空',
            'name.between' => '用户名只能在2到20位',
            'name.unique' => '用户名已经存在',
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
            'email.unique' => '邮箱已经存在',
            'password.required' => '密码不能为空',
            'password.between' => '密码只能在6到20位',
            'password.confirmed' => '两次密码不一致',
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '验证码不正确'
        ];
    }
}
