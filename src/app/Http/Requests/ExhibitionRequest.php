<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * categoryはitems_tableと多対多のリレーション
     */
    public function rules(): array
    {
        return [
            'item_name' => 'required|string',
            'image_url' => 'required|image|mimes:jpeg,png',
            'brand' => 'nullable',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|integer',
            'description' => 'required|string|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'integer|distinct|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'item_name.required' => '商品名を入力してください',
            'image_url.required' => '商品名を入力してください',
            'image_url.mimes' => 'ファイルはjpegまたはpng形式にしてください',
            'price.required' => '商品の金額を入力してください',
            'price.min' => '価格は０円以上で入力してください',
            'condition.required' => '商品の状態を選択してください',
            'description.required' => '商品の説明を入力してください',
            'categories.required' => 'カテゴリーを１つ以上選択してください',
        ];
    }
}
