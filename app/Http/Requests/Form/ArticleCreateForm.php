<?php

namespace App\Http\Requests\Form;

use App\Http\Requests\Request;

class ArticleCreateForm extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'                 => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'                  => '文章标题不能为空',
        ];
    }
}