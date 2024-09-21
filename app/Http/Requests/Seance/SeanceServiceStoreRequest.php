<?php

namespace App\Http\Requests\Seance;

use App\Http\Enums\PayType;
use App\Http\Enums\PercentType;
use App\Http\Services\Helper;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SeanceServiceStoreRequest extends FormRequest
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
        $cover_master = (int) ($this->cover_master_id ?? 0);
        if ($cover_master <= 1) {
            $this->merge([
                'cover_master_id' => null,
                'cover_master_percent' => 0,
            ]);
        } else {
            $cover_master_percent = (int) ($this->cover_master_percent ?? 0);
            if ($cover_master_percent <= 1) {
                $this->merge(['cover_master_percent' => Helper::masterPercent(User::find($this->cover_master_id)->roles, PercentType::Program->value)]);
            }
        }

        $admin_percent = (int) ($this->admin_percent ?? 0);
        if ($admin_percent <= 1) {
            $this->merge(['admin_percent' => Helper::adminPercent(User::find(auth()->id())->roles, PercentType::Program->value)]);
        }

        $master_percent = (int) ($this->master_percent ?? 0);
        if ($master_percent <= 1) {
            $this->merge(['master_percent' => Helper::masterPercent(User::find($this->master_id)->roles, PercentType::Program->value)]);
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
            'master_id' => ['required', 'integer'],
            'cover_master_id' => ['nullable', 'integer'],
            'master_percent' => ['required', 'integer'],
            'cover_master_percent' => ['required', 'integer'],

            'service_id' => ['required', 'integer'],
            'guest' => ['nullable', 'string'],
            'open_time' => ['nullable', 'string'],
            'close_time' => ['nullable', 'string'],

            'cash_payed' => ['required', 'integer'],
            'card_payed' => ['required', 'integer'],
            'phone_payed' => ['required', 'integer'],
            'cert_payed' => ['required', 'integer'],
            'sale_payed' => ['required', 'integer'],
            'handle_price' => ['nullable', 'integer'],

            'from' => ['nullable', 'string'],
            'note' => ['nullable', 'string'],
            'status' => ['nullable', 'integer'],
        ];
    }
}
