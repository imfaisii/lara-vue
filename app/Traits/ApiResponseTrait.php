<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Response;

trait ApiResponseTrait
{
    /**
     * Return a success JSON response.
     *
     * @param  mixed  $data
     * @param  string|null  $message
     * @param  int  $status
     * @return \Illuminate\Http\Response
     */
    public function successResponse($data, $message = null, $status = Response::HTTP_OK)
    {
        return response([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    /**
     * Return an error JSON response.
     *
     * @param  string|null  $message
     * @param  int  $status
     * @return \Illuminate\Http\Response
     */
    public function errorResponse($message = null, $status = Response::HTTP_BAD_REQUEST)
    {
        return response([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    /**
     * Return an exception JSON response.
     *
     * @param  string|null  $message
     * @param  int  $status
     * @return \Illuminate\Http\Response
     */
    public function exceptionResponse(Exception $e, $code = null)
    {
        return response([
            'success' => false,
            'message' => $e->errorInfo[2] ?? $e->getMessage() ?? Response::HTTP_INTERNAL_SERVER_ERROR,
        ], $code ?? 500);
    }
}
