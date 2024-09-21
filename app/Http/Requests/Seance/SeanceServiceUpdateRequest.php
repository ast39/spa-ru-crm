<?php

namespace App\Http\Requests\Seance;

use App\Http\Enums\PayType;
use App\Http\Enums\PercentType;
use App\Http\Services\Helper;
use App\Models\User;
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
            'cover_master_id' => ['nullable', 'integer'],
            'admin_percent' => ['nullable', 'integer'],
            'master_percent' => ['nullable', 'integer'],
            'cover_master_percent' => ['nullable', 'integer'],

            'service_id' => ['nullable', 'integer'],
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
