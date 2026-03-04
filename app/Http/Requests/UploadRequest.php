<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cover' => 'required|image|max:10240',
        ];
    }
}
