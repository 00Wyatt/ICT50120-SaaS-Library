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
                'max:255',
            ],
            'subtitle' => [
                'max:255',
            ],
            'year_published' => [
                'numeric',
                'min:1450'
            ],
            'edition' => [
                'integer',
                'min:1'
            ],
            'isbn_10' => [
                'size:10'
            ],
            'isbn_13' => [
                'size:13'
            ],
            'height' => [
                'min:0',
                'smallInteger'
            ],
            'genre' => [
                'max:255'
            ],
            'sub_genre' => [
                'max:255'
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
