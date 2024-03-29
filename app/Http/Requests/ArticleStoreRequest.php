<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleStoreRequest extends FormRequest
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
            'title' => 'required|min:2|max:10',
            'content'=>'required',
            'category_id' =>'required',
        ];
    }
    public function message()
    {
        return [
            'title' => 'title min2 required',
            'category_id' => 'play number'
        ];
    }
    }
