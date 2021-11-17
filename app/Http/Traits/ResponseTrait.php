<?php

namespace App\Http\Traits;

trait ResponseTrait
{
    /**
     * Custom error response
     * @param $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, int $status = 500)
    {
        return response()->json([
            'message' => $message,
            'status' => $status
        ], $status);
    }
}