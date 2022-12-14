<?php
namespace App\Traits;

trait ApiResponse {
    protected function responseJsonForBidden() {
        return response()->json([
            'message' => 'Unauthorized',
            'code' => '403'
        ], 403);
    }

    protected function responseData($data, $code = 200) {
        return response()->json($data, $code);
    }
}
