<?php

namespace App\Http\Requests\Service;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ServiceStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            'title'   => ['required', 'string'],
            'price'   => [
                'required',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'note'   => ['nullable', 'string'],
            'status' => ['nullable', 'integer'],
        ];
    }
}
