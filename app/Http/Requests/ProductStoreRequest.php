<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'code' => ['required','string','max:50','unique:products,code'],
            'name' => ['required','string','max:150'],
            'category_id' => ['required','exists:categories,id'],
            'unit_id' => ['required','exists:units,id'],
            'cost_price' => ['required','integer','min:0'],
            'sell_price' => ['required','integer','min:0'],
            'stock_minimum' => ['required','integer','min:0'],
            'is_active' => ['required','boolean'],
            'photo' => ['nullable','image','max:2048'],
        ];
    }
}
