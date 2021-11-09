<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'firstNameUser' => 'required|string',
            'lastNameUser' => 'required|string',
            'phoneUser' => 'required|string',
            'loginNameUser' => 'required|string',
            'loginPasswordUser' => 'required|string',
            'idRolUser' => 'required|integer',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ], 400));
    }


}
