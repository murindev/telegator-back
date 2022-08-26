<?php


namespace App\Services\Api;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiAnswerService
{
    public static function successfulAnswer($status = null): JsonResponse
    {
        if ($status === null) {
            $status = Response::HTTP_OK;
        }

        return response()->json(['status' => 'success'], $status);
    }

    public static function successfulAnswerWithData($data, $status = null) : JsonResponse
    {
        if ($status === null) {
            $status = Response::HTTP_OK;
        }

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], $status);
    }

    public static function errorAnswer($message, $status = null): JsonResponse
    {
        if ($status === null) {
            $status = Response::HTTP_OK;
        }

        return response()->json(
            [
                'status' => 'error',
                'message' => $message
            ],
            $status
        );
    }
}
