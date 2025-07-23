<?php

namespace App\Http\Requests\Admin\Catalogs;

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
            'title' => 'required|string',
            'id_parent' => 'nullable|integer',
        ];
    }
}
