<?php

namespace App\Http\Requests\Seance;

use App\Http\Enums\PayType;
use App\Http\Enums\PercentType;
use App\Http\Services\Helper;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SeanceBarUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        if (!is_null($this->admin_percent ?? null) && $this->admin_percent == 0) {
            $this->merge(['admin_percent' => Helper::adminPercent(User::find(auth()->id())->roles, PercentType::Program->value)]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            'admin_percent' => ['required', 'integer'],

            'item_id' => ['required', 'integer'],
            'guest' => ['nullable', 'string'],
            'note' => ['nullable', 'string'],

            'cash_payed' => ['nullable', 'integer'],
            'card_payed' => ['nullable', 'integer'],
            'phone_payed' => ['nullable', 'integer'],
            'cert_payed' => ['nullable', 'integer'],
            'sale_payed' => ['nullable', 'integer'],
            'handle_price' => ['nullable', 'integer'],
        ];
    }
}
