<?php

namespace App\Http\Controllers;

trait ResponseTrait
{
    public function successResponse($data, $message = '')
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message
        ]);
    }

    public function errorResponse($message = '', $status = 400)
    {
        return response()->json([
            'success' => false,
            'data' => [],
            'message' => $message
        ], $status);
    }
}
