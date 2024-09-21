<?php

namespace App\Http\Requests\Seance;

use App\Http\Enums\PayType;
use App\Http\Enums\PercentType;
use App\Http\Services\Helper;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SeanceBarStoreRequest extends FormRequest
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
        if (($this->admin_percent ?? 0) == 0) {
            $this->merge(['admin_percent' => Helper::adminPercent(User::find(auth()->id())->roles, PercentType::Program->value)]);
        }

        if (is_null($this->cash_payed ?? null)) {
            $this->merge(['cash_payed' => 0]);
        }

        if (is_null($this->card_payed ?? null)) {
            $this->merge(['card_payed' => 0]);
        }

        if (is_null($this->phone_payed ?? null)) {
            $this->merge(['phone_payed' => 0]);
        }

        if (is_null($this->cert_payed ?? null)) {
            $this->merge(['cert_payed' => 0]);
        }

        if (is_null($this->sale_payed ?? null)) {
            $this->merge(['sale_payed' => 0]);
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

            'cash_payed' => ['required', 'integer'],
            'card_payed' => ['required', 'integer'],
            'phone_payed' => ['required', 'integer'],
            'cert_payed' => ['required', 'integer'],
            'sale_payed' => ['required', 'integer'],
            'handle_price' => ['nullable', 'integer'],

        ];
    }
}
