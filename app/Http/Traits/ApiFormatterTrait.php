<?php


namespace App\Http\Traits;


use Illuminate\Http\JsonResponse;

trait ApiFormatterTrait
{
    /**
     * format success response
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    public function success($data, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], $code);
    }

    /**
     * format error response
     * @param array $message
     * @param int $code
     * @return JsonResponse
     */
    public function error(array $message, int $code = 200): JsonResponse
    {

        return response()->json([
            'status' => 'error',
            'errors' => $message,
        ], $code);
    }
}
