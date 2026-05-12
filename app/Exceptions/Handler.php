<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;

class Handler extends Exception
{
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // return response()->json([
        //     'success' => false,
        //     'message' => 'Authentication required.',
        // ], 401);
    }

    // public function render($request, \Throwable $exception)
    // {
    //     if ($exception instanceof \Illuminate\Validation\ValidationException) {
    //         return failed_response('Validation failed', $exception->errors());
    //     }

    //     if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
    //         return failed_response('Resource not found');
    //     }

    //     if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
    //         return failed_response('Endpoint not found');
    //     }

    //     if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
    //         return failed_response('Unauthenticated');
    //     }

    //     // Default server error
    //     return failed_response($exception->getMessage() ?: 'Something went wrong');
    // }
}
