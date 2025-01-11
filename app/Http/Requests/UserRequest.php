<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'second_name' => ['max:50', 'string', 'nullable']
        ];

        if ($this->segment(3) === "register") {
            $rules["email"] = ['required', 'string', 'email', 'max:255', 'unique:users'];
            $rules["password"] = ['required', 'string'];
            $rules['name'] = ['required', 'string', 'max:50'];
            $rules['last_name'] = ['required', 'string', 'max:50'];
        } elseif ($this->segment(3) === 'update') {
            $rules['password'] = ['string', 'max:50'];
            $rules['name'] = ['string', 'max:50'];
            $rules['last_name'] = ['string', 'max:50'];
            $rules['second_name'] = ['string', 'max:50'];
            $rules['role'] = ['string', 'in:admin,customer'];
        }

        return $rules;
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
