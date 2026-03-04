<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(UploadRequest $request)
    {
        $file = $request->file('cover');
        $path = now()->format('Y-m-d');
        $filename = uniqid().'_'.$file->getClientOriginalName();
        $storedPath = $file->storeAs($path, $filename, 'public');

        return response()->json([
            'path' => Storage::url($storedPath),
        ]);
    }
}
