<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'active' => ['in:Y,N'],
        ];

        if ($this->segment(3) === 'update') {
            $rules['password'] = ['string', 'max:50'];
            $rules['name'] = ['string', 'max:50'];
            $rules['last_name'] = ['string', 'max:50'];
            $rules['second_name'] = ['string', 'max:50'];
            $rules['role'] = ['string', 'in:admin,customer'];
        }

        return $rules;
    }
}
