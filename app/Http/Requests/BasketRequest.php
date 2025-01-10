<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BasketRequest extends FormRequest
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
        $rules = [];
        // Проверка для метода add
        if ($this->isMethod('post') && $this->routeIs('basket.add')) {
            $rules = [
                'basket' => 'required|array',
                'basket.*.nomenclature_guid' => 'required|string|size:36|exists:nomenclatures,guid',
                'basket.*.amount' => 'required|numeric|min:1',
            ];
        }

        // Проверка для метода delete
        if ($this->isMethod('post') && $this->routeIs('basket.delete')) {
            $rules = [
                'guids' => 'required|array',
                'guids.*' => 'required|string|size:36|exists:basket,nomenclature_guid',
            ];
        }

        // Проверка для метода clear
        if ($this->isMethod('post') && $this->routeIs('basket.clear')) {
            $rules = [];
        }

        return $rules;
    }

    // Сообщения об ошибках
    public function messages()
    {
        return [
            'basket.required' => 'The basket field is required.',
            'basket.array' => 'The basket must be an array.',
            'basket.*.nomenclature_guid.required' => 'Each item must have a nomenclature GUID.',
            'basket.*.nomenclature_guid.exists' => 'The provided nomenclature GUID does not exist.',
            'basket.*.amount.required' => 'The amount is required for each item.',
            'basket.*.amount.numeric' => 'The amount must be a number.',
            'basket.*.amount.min' => 'The amount must be at least 1.',
            'guids.required' => 'The guids field is required.',
            'guids.array' => 'The guids must be an array.',
            'guids.*.exists' => 'One or more GUIDs are not found in the basket.',
            'guids.*.size' => 'Each GUID must be 36 characters.',
        ];
    }
};
