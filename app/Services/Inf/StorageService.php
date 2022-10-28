<?php

namespace App\Services\Inf;

use Illuminate\Support\Facades\Storage;

class StorageService
{
    public function saveToLocalStorage($path, $file, $name = null)
    {
        $name = $name ?? auth()->user()->id . time() . '.' . $file->getClientOriginalExtension();
        $result = Storage::putFileAs($path, $file, $name);
        return $result;
    }
}
