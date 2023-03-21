<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
    public function messages()
    {
        return [
            'min' => 'The :attribute must have value atleast :min',
            'max' => 'The :attribute is not more than :max',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'seller_id' => 'required|integer',
            'category_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:250',
            'details' => 'required|array',
            'details.*.variant' => 'required|string',
            'details.*.sku' => 'required|string',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.baseprice' => 'required|integer|min:0',
            'details.*.het' => 'required|integer|min:0',
            'details.*.weight' => 'required|numeric',
            'details.*.unit' => 'required|string',

        ];
    }
}
