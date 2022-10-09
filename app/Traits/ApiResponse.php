<?php
namespace App\Traits;

trait ApiResponse {
    protected function responseJsonForBidden() {
        return response()->json([
            'message' => 'Unauthorized',
            'code' => '403'
        ]);
    }

    protected function responseSuccess($data, $code = 200) {
        return response()->json($data);
    }
}
