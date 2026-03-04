<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
{
    public function rules(): array
    {
        $updateById = $this->route('project') ? ",$this->id" : null;

        return [
            'category_id' => $updateById ? 'sometimes' : 'required'.'|exists:categories,id',
            'title' => 'required|string|min:3|max:255|unique:projects,title'.$updateById,
            'price' => 'nullable|string|max:20',
            'cover' => 'nullable|string|max:255',
            'details' => 'nullable|array',
            'content' => 'nullable|string',
        ];
    }
}
