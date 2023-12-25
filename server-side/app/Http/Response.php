<?php

namespace App\Http;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;

class Response
{
    /**
     * @param string $message
     * @param mixed|null $data
     * @param int $code
     * @param ResponseFactory|null $responseFactory
     * @return JsonResponse
     */
    public static function success(string $message, $data = null, int $code = 200, ResponseFactory $responseFactory = null): JsonResponse
    {
        $responseFactory = $responseFactory ?: app(ResponseFactory::class);

        $responseData = [
            'success' => true,
            'message' => $message,
        ];

        if ($data) {
            $responseData['content'] = $data;
        }

        return $responseFactory->json($responseData, $code);
    }


    /**
     * @param $data
     * @return JsonResponse
     */
    public static function successWithPagination($data): JsonResponse
    {
        if ($data != null) {
            $response["success"] = true;
            if (is_array($data)) {
                $response = array_merge($response, $data);
            } else {
                $response = array_merge($response, $data->toArray());
            }
        } else {
            $response = ["success" => true];
        }

        return self::returnJson($response);
    }

    /**
     * @param string $message
     * @param array|string|null $reason
     * @param int $code
     * @param ResponseFactory|null $responseFactory
     * @return JsonResponse
     */
    public static function error(string $message, array|string $reason = null, int $code = 500, ResponseFactory $responseFactory = null): JsonResponse
    {
        $responseFactory = $responseFactory ?: app(ResponseFactory::class);

        $error = ["code" => $code, "message" => $message, "reason" => $reason];
        $data = ["success" => false, "error" => $error];

        return $responseFactory->json($data, $code);
    }

    /**
     * @param mixed $data
     * @param int $code
     * @param ResponseFactory|null $responseFactory
     * @return JsonResponse
     */
    public static function returnJson($data, int $code = 200, ResponseFactory $responseFactory = null): JsonResponse
    {
        $responseFactory = $responseFactory ?: app(ResponseFactory::class);
        return $responseFactory->json($data, $code);
    }
}
