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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:25',
            'content' => 'required|max:255',
            'creator_id' => 'required',
            'image' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is reqired',
            'title.max' => 'Title max :max character',
            'content.required' => 'Content is reqired',
            'content.max' => 'Content max :max character',
            'creator_id.required' => 'Creator is reqired',
            'image.required' => 'Image is reqired',
        ];
    }
}
