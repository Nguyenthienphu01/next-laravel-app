<?php

namespace App\Http\Api\V1\Controllers;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Common error response
     * @author PhuNguyen
     * @since 2024-11-20
     * @param string $message
     * @param array $data
     * @param int $code
     * @return Illuminate\Http\JsonResponse
     */
    public function responseError(string $message = '', array $data = [], int $code = 500): JsonResponse
    {
        if (empty($message)) {
            $message = __('common.update_fails');
        }
        if (empty($data)) {
            $data = (object) $data;
        }
        return response()->json([
            'result' => false,
            'code' => config('constants.SYSTEM_ERROR_CODE'),
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    /**
     * Common error response V2
     * @author PhuNguyen
     * @since 2024-11-20
     * @param string $message
     * @param array $data
     * @param int $code
     * @return Illuminate\Http\JsonResponse
     */
    public function responseErrorV2(string $message = '', String $code = '', array $data = [] , int $statusCode = 500): JsonResponse
    {
        if (empty($message)) {
            $message = __('common.update_fails');
        }
        if (empty($data)) {
            $data = (object) $data;
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
    /**
     * Common success response
     * @author PhuNguyen
     * @since 2024-11-20
     * @param string $message
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    public function responseSuccess(array $data = [], string $message = '', string|int $code = 200, int $httpCode = 200): JsonResponse
    {
        if (empty($data)) {
            $data = (object) $data;
        }
        if (empty($message)) {
            $message = __('common.common_success');
        }
        return response()->json([
            'code' => strval($code),
            'message' => $message,
            'data' => $data,
        ], $httpCode);
    }
}