<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

/**
 * Format response.
 */
class ResponseFormatter
{
    /**
     * API Response
     *
     * @var array
     */
    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => null,
        ],
        'data' => null,
    ];

    /**
     * Give success response.
     *
     * @param mixed|null $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    public static function success($data = null, string $message = null, int $code = 200): JsonResponse
    {
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, $code);
    }

    /**
     * Give error response.
     *
     * @param mixed|null $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    public static function error($data = null, string $message = null, int $code = 400): JsonResponse
    {
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, $code);
    }
}
