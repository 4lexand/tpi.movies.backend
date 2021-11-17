<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SaleRequest extends FormRequest
{public function rules()
{
    return [
        'idUserSale' => 'required|numeric',
        'idMovieSale' => 'required|numeric',
        'dateSale' => 'required|date'
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
