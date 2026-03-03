<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            // 内容書き換える
            'avatar_url' => 'nullable|image|mimes:jpeg,png',
            'user_name' => 'required|string|max:20',
            'zip_code' => 'required|regex:/^\d{3}-\d{4}$/',
            'address' => 'required|string',
            'building' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'avatar_url.image' => '画像ファイルを選択してください',
            'avatar_url.mimes' => '画像はjpegまたはpng形式でアップロードしてください。',
            'user_name.required' => 'ユーザー名を入力してください',
            'user_name.max' => 'ユーザー名は20文字以内で入力してください',
            'zip_code.required' => '郵便番号を入力してください。',
            'zip_code.regex' => '郵便番号はハイフンありの8桁で入力してください。',
            'address.required' => '住所を入力してください。',
        ];
    }
}
