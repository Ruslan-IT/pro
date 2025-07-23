<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product.title'=> 'required|string|max:255',
            'product.price' => 'required|numeric|min:0',
            'product.sklad' => 'required|numeric|min:0',
            'product.id_parent' => 'required|numeric|min:0',
            'images' =>  'nullable|array',
            'images *' => 'required|file',
        ];
    }
}
