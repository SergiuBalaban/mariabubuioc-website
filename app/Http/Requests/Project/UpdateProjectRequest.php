<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => 'sometimes|exists:categories,id',
            'title' => 'sometimes|string|min:3|max:255|unique:projects,title'.$this->id,
            'price' => 'nullable|string|max:20',
            'cover' => 'nullable|string|max:255',
            'details' => 'nullable|array',
            'images' => 'nullable|array',
            'content' => 'nullable|string',
        ];
    }
}
