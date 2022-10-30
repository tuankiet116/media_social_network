<?php

namespace App\Services\Inf;

use Illuminate\Support\Facades\Storage;

class StorageService
{
    public function saveToLocalStorage($path, $file, $returnPath = true, $name = null)
    {
        $name = $name ?? auth()->user()->id . time() . '.' . $file->getClientOriginalExtension();
        $result = Storage::putFileAs($path, $file, $name);
        return $returnPath ? $result : $name;
    }

    public function getImage($path) {
        return Storage::get($path);
    }
}
