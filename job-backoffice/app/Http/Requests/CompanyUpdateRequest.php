<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('companies', 'name')->ignore(
                    optional($this->route('company'))->id ?? $this->route('company') ?? $this->user()->company->id
                )
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

            // Owner fields
            'owner_name' => [
                'required',
                'string',
                'max:255',
            ],
            'owner_password' => [
                'nullable',
                'string',
                'min:8',
            ],
        //    'owner_current_password' => [
        //     'nullable', // نسمح يتركه فاضي لو مش ناوي يغير الباسورد
        //     'required_with:owner_password', // لازم يعبيه إذا كتب owner_password
        //     'current_password:web', // Laravel rule يتحقق أن كلمة السر صحيحة لحساب الأونر
        //    ],
        ];
    }

    public function messages()
    {
        return [
            // Company
            'name.required' => 'The company name is required.',
            'name.unique' => 'The company name must be unique.',
            'name.max' => 'The company name may not be greater than 255 characters.',
            
            'address.required' => 'The address is required.',
            'address.max' => 'The address may not be greater than 255 characters.',

            'industry.required' => 'The industry is required.',
            'industry.max' => 'The industry may not be greater than 255 characters.',

            'website.url' => 'The website must be a valid URL.',
            'website.max' => 'The website may not be greater than 255 characters.',

            // Owner
            'owner_name.required' => 'The owner name is required.',
            'owner_name.max' => 'The owner name may not be greater than 255 characters.',
            
        //       'owner_current_password.required_with' => 'The current password is required when changing the owner password.',
        // 'owner_current_password.current_password' => 'The current password is incorrect.',


            'owner_password.min' => 'The password must be at least 8 characters.',
        ];
    }
}
