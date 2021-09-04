<?php

namespace App\Post\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class PostCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['required'],
            'message' => ['required']
        ];
    }
}
