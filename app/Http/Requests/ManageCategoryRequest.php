<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManageCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        $update = $this->route('category') ? ",$this->id" : null;

        return [
            'name' => 'required|string|min:3|max:255|unique:categories,name'.$update,
        ];
    }
}
