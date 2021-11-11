<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MovieRequest extends FormRequest
{
    public function rules()
    {
        return [
            'titleMovie' => 'required|string',
            'descriptionMovie' => 'required|string',
            'urlImageMovie' => 'required|url',
            'urlTrailerMovie' => 'required|url',
            'stockMovie' => 'required|integer',
            'rentalPriceMovie' => 'required|numeric',
            'purchasePriceMovie' => 'required|numeric',
            'availabilityMovie' => 'required|integer',
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
