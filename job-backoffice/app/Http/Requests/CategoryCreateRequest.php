<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryCreateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('jobcategories', 'name')->ignore($this->route('category')),
            ],
        ];
        
    }

    


    public function messages()
    {
        return [
            'name.required' => 'The category name is required.',
            'name.unique' => 'The category name must be unique.',
            'name.max' => 'The category name may not be greater than 255 characters.',
        ];
    }
}
