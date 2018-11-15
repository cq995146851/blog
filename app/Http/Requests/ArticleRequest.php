<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'topic_id' => 'required',
            'title' => 'required|between:2,30',
            'content' => 'required|min:10'
        ];
    }

    public function messages()
    {
        return [
            'topic_id.required' => '帖子专题必须选择',
            'title.required' => '标题不能为空',
            'title.between' => '标题长度只能在2到30之间',
            'content.required' => '内容不能为空',
            'content.min' => '内容长度不能低于10'
        ];
    }
}
