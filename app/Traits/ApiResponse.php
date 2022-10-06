<?php
namespace App\Traits;

trait ApiResponse {
    protected function responseJsonForBidden() {
        return response()->json([
            'message' => 'Unauthorized',
            'code' => '403'
        ]);
    }
}
