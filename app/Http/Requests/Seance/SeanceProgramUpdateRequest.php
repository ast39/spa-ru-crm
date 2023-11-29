<?php

namespace App\Http\Requests\Seance;

use App\Http\Enums\PayType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SeanceProgramUpdateRequest extends FormRequest
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

            'master_id' => ['nullable', 'integer'],
            'program_id' => ['nullable', 'integer'],
            'guest' => ['nullable', 'string'],
            'open_time' => ['nullable', 'string'],
            'close_time' => ['nullable', 'string'],
            'handle_price' => ['nullable', 'integer'],
            'sale' => ['nullable', 'integer'],
            'pay_type' => ['nullable', new Enum(PayType::class)],
            'from' => ['nullable', 'string'],
            'note' => ['nullable', 'string'],
            'status' => ['nullable', 'integer'],

            'services' => ['nullable', 'array'],
            'services.*' => ['nullable', 'array'],
            'services.*.amount' => ['nullable', 'integer'],
            'services.*.gift' => ['nullable', 'string'],

            'bar' => ['nullable', 'array'],
            'bar.*' => ['nullable', 'array'],
            'bar.*.amount' => ['nullable', 'integer'],
            'bar.*.gift' => ['nullable', 'string'],
        ];
    }
}
