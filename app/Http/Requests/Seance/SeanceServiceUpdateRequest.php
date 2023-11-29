<?php

namespace App\Http\Requests\Seance;

use App\Http\Enums\PayType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SeanceServiceUpdateRequest extends FormRequest
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

            'master_id' => ['required', 'integer'],
            'guest' => ['nullable', 'string'],
            'sale' => ['nullable', 'integer'],
            'pay_type' => ['nullable', new Enum(PayType::class)],
            'note' => ['nullable', 'string'],
            'amount' => ['nullable', 'integer'],
            'gift' => ['nullable', 'string'],
        ];
    }
}
