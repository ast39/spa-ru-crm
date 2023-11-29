<?php

namespace App\Http\Requests\Program;

use App\Http\Enums\ProgramType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ProgramUpdateRequest extends FormRequest
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

            'title'      => ['nullable', 'string'],
            'type'       => [
                'nullable',
                new Enum(ProgramType::class)
            ],
            'period'     => ['nullable', 'int'],
            'price'      => [
                'nullable',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'note'       => ['nullable', 'string'],
            'status'     => ['nullable', 'integer'],
        ];
    }
}
