<?php

namespace App\Support;

use App\Support\HttpCode;
use Illuminate\Http\Response;

class ApiResponse
{
    /**
     * Error response
     */
    public static function error(string $message, int $code = HttpCode::HTTP_BAD_REQUEST): Response
    {
        return new Response([
            'statusCode' => $code,
            'message' => $message,
        ], $code);
    }

    /**
     * Success response
     */
    public static function success(?string $message = null, $data = null, int $code = HttpCode::HTTP_OK): Response
    {
        return new Response([
            'statusCode' => $code,
            'message' => $message ?? 'Success processing request',
            'data' => $data,
        ], $code);
    }

    /**
     * Failed Validation
     */
    public static function failedValidation(string|array $message, $data = null, int $code = HttpCode::HTTP_UNPROCESSABLE_ENTITY): Response
    {
        return new Response([
            'statusCode' => $code,
            'message' => is_array($message) ? $message[0] : $message,
        ], $code);
    }

     /**
     * Success response
     */
    public static function paginate(?string $message = null, $data = null, int $code = HttpCode::HTTP_OK): Response
    {
        return new Response([
            'statusCode' => $code,
            'message' => $message ?? 'Success processing request',
            'data' => $data['data'] ?? $data,
            'pagination' => $data['pagination'] ?? null
        ], $code);
    }
}
