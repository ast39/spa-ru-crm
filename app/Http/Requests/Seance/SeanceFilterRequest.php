<?php

namespace App\Http\Requests\Seance;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SeanceFilterRequest extends FormRequest
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

            'admin'   => ['nullable', 'integer'],
            'master'  => ['nullable', 'integer'],
            'program' => ['nullable', 'integer'],
            'guest'   => ['nullable', 'string'],
            'from'    => ['nullable', 'date_format:Y-m-d'],
            'to'      => ['nullable', 'date_format:Y-m-d'],
            'status'  => ['nullable', 'integer'],
        ];
    }
}
