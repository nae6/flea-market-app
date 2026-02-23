<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payment_method' => 'required|in:konbini,card',
        ];
    }

    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法を選択してください。',
            'payment_method.in' => '支払い方法はコンビニ払いまたはカード払いから選択肢してください。',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $shipping = session('shipping', []);
            $profile  = $this->user()?->profile;

            $zip = $shipping['zip_code'] ?? $profile?->zip_code;
            $addr = $shipping['address'] ?? $profile?->address;

            if (!$zip || !$addr) {
                $validator->errors()->add('shipping', '配送先を入力してください。');
            }
        });
    }
}
