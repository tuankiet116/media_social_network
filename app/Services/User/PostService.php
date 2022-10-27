<?php

namespace App\Services\User;

use App\Services\Inf\StorageService;
use App\Traits\ApiResponse;

class PostService
{
    use ApiResponse;
    protected $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }
    public function uploadImageCkEditor($file)
    {
        $result = $this->storageService->saveToLocalStorage('app/ckfinder', $file);
        return $result;
    }

    public function getImageCkEditor($fileName) {

    }
}
