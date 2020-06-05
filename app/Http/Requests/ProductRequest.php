<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required', 
            'description' => 'required', 
            'price' => 'required', 
            'slug' => 'required', 
            'weigth' => 'required', 
            'width' => 'required', 
            'heigth' => 'required', 
            'depth' => 'required',
            'tags' => 'required'
        ];
    }
}
