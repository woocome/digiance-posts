<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer',
            'userId' => 'required|integer',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'The post ID is required.',
            'id.integer' => 'The post ID must be an integer.',
            'userId.required' => 'The user ID is required.',
            'userId.integer' => 'The user ID must be an integer.',
            'title.required' => 'The title is required.',
            'body.required' => 'The body is required.',
        ];
    }
}

