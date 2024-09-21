<?php

namespace App\Http\Requests\Seance;

use App\Http\Enums\PercentType;
use App\Http\Services\Helper;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;


class SeanceProgramUpdateRequest extends FormRequest
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

            'master_id' => ['nullable', 'sometimes', 'integer'],
            'cover_master_id' => ['nullable', 'sometimes', 'integer'],
            'admin_percent' => ['nullable', 'sometimes', 'numeric'],
            'master_percent' => ['nullable', 'sometimes', 'numeric'],
            'cover_master_percent' => ['nullable', 'sometimes', 'numeric'],

            'program_id' => ['nullable', 'integer'],
            'guest' => ['nullable', 'sometimes', 'string'],
            'open_time' => ['nullable', 'sometimes', 'string'],
            'close_time' => ['nullable', 'sometimes', 'string'],

            'cash_payed' => ['nullable', 'integer'],
            'card_payed' => ['nullable', 'integer'],
            'phone_payed' => ['nullable', 'integer'],
            'cert_payed' => ['nullable', 'integer'],
            'sale_payed' => ['nullable', 'integer'],
            'handle_price' => ['nullable', 'integer'],

            'from' => ['nullable', 'sometimes', 'string'],
            'note' => ['nullable', 'sometimes', 'string'],
            'status' => ['nullable', 'sometimes', 'integer'],
        ];
    }
}
