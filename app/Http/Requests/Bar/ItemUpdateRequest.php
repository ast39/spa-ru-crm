<?php

namespace App\Http\Requests\Bar;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ItemUpdateRequest extends FormRequest
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

            'title'   => ['nullable', 'string'],
            'portion' => ['nullable', 'string'],
            'price'   => [
                'nullable',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'stock'  => ['nullable', 'integer'],
            'note'   => ['nullable', 'string'],
            'status' => ['nullable', 'integer'],
        ];
    }
}
