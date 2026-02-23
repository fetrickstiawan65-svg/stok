<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitStoreRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:50','unique:units,name'],
            'symbol' => ['required','string','max:10','unique:units,symbol'],
        ];
    }
}
