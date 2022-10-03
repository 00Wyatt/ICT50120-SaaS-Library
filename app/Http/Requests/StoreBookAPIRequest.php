<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreBookAPIRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => [
                'required',
                'max:64',
            ],
            'subtitle' => [
                'max:128',
            ],
            'year_published' => [
                'nullable'
            ],
            'edition' => [
                'integer'
            ],
            'isbn_10' => [
                'min:10',
                'max:10'
            ],
            'isbn_13' => [
                'min:13',
                'max:13'
            ],
            'height' => [
                'smallInteger'
            ],
            'genre' => [
                'max:32'
            ],
            'sub_genre' => [
                'max:32'
            ],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'title' => 'A title is required'
        ];
    }
}
