<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Company Information
            'name' => [
                'required',
                'string',
                'max:255',
                // Rule::unique('companies', column: 'name')->ignore($this->route('company')),
            ],
            'address' => [
                'required',
                'string',
                'max:255',
            ],
            'industry' => [
                'required',
                'string',
                'max:255',
            ],
            'website' => [
                'nullable',
                'url',
                'max:255',
            ],
   

            // Owner Information
            'owner_name' => [
                'required',
                'string',
                'max:255',
            ],
            'owner_email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'owner_password' => [
                'required',
                'string',
                'min:8',
            ],
            
            
        ];
    }

    public function messages()
    {
        return [
            // Company messages
            'name.required' => 'The company name is required.',
            'name.unique' => 'The company name must be unique.',
            'name.max' => 'The company name may not be greater than 255 characters.',
            
            'address.required' => 'The address is required.',
            'address.max' => 'The address may not be greater than 255 characters.',

            'industry.required' => 'The industry is required.',
            'industry.max' => 'The industry may not be greater than 255 characters.',

            'website.url' => 'The website must be a valid URL.',
            'website.max' => 'The website may not be greater than 255 characters.',

            'email.required' => 'The company email is required.',
            'email.email' => 'The company email must be a valid email address.',
            'email.unique' => 'The company email must be unique.',
            'email.max' => 'The company email may not be greater than 255 characters.',

            'ownerId.exists' => 'The selected owner ID is invalid.',    

            // Owner messages
            'owner_name.required' => 'The owner name is required.',
            'owner_name.max' => 'The owner name may not be greater than 255 characters.',

            'owner_email.required' => 'The owner email is required.',
            'owner_email.email' => 'The owner email must be a valid email address.',
            'owner_email.unique' => 'The owner email alredy exist',
            'owner_email.max' => 'The owner email may not be greater than 255 characters.',

            'owner_password.required' => 'The owner password is required.',
            'owner_password.min' => 'The owner password must be at least 8 characters.',
        ];
    }
}
