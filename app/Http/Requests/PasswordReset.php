<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordReset extends FormRequest
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
            'password' => 'required|between:6,20|confirmed',
            'captcha' => 'required|captcha'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => '密码不能为空',
            'password.between' => '密码只能在6到20位',
            'password.confirmed' => '两次密码不一致',
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '验证码不正确'
        ];
    }
}
