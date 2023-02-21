<?php


namespace App\Services\Http\Responses;


class JsonResponse
{
    public static function ok(object|array|string $data = '', string $type = 'message', string $status = 'ok', int $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            $type => $data,
            'status' => $status,
            'type' => $type,
        ], $code);
    }

    public static function error(string $msg, int $code): \Illuminate\Http\JsonResponse
    {
        return response()->json(['message' => $msg], $code);
    }

    public static function serverError(): \Illuminate\Http\JsonResponse
    {
        return static::error('Server error', 500);
    }

    public static function srcNotFound(): \Illuminate\Http\JsonResponse
    {
        return static::error('Resource not found', 404);
    }
}
