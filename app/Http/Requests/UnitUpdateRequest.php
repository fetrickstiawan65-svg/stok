<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitUpdateRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('unit')->id;
        return [
            'name' => ['required','string','max:50',"unique:units,name,$id"],
            'symbol' => ['required','string','max:10',"unique:units,symbol,$id"],
        ];
    }
}
