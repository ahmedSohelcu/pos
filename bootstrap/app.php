<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// use Illuminate\Validation\ValidationException;
// use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Illuminate\Auth\AuthenticationException;
// use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
// use Illuminate\Database\QueryException;
// use Illuminate\Support\Facades\Log;
// use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        //
    })

    ->withExceptions(function (Exceptions $exceptions) {

        // $exceptions->render(function (Throwable $e, $request) {

        //     // Only format JSON for API requests
        //     if (! $request->expectsJson()) {
        //         return null;
        //     }

        //     /*
        //     |--------------------------------------------------------------------------
        //     | Validation Exception (422)
        //     |--------------------------------------------------------------------------
        //     */
        //     if ($e instanceof ValidationException) {
        //         return response()->json([
        //             'status' => false,
        //             'message' => trans('default.validation_failed_response'),
        //             'data' => null,
        //             'errors' => $e->errors(),
        //         ], 422);
        //     }

        //     /*
        //     |--------------------------------------------------------------------------
        //     | Model Not Found (404)
        //     |--------------------------------------------------------------------------
        //     */
        //     if ($e instanceof ModelNotFoundException) {
        //         return response()->json([
        //             'status' => false,
        //             'message' => trans('default.not_found_response', [
        //                 'name' => class_basename($e->getModel())
        //             ]),
        //             'data' => null,
        //             'errors' => [],
        //         ], 404);
        //     }

        //     /*
        //     |--------------------------------------------------------------------------
        //     | Authentication (401)
        //     |--------------------------------------------------------------------------
        //     */
        //     if ($e instanceof AuthenticationException) {
        //         return response()->json([
        //             'status' => false,
        //             'message' => trans('default.unauthenticated_response'),
        //             'data' => null,
        //             'errors' => [],
        //         ], 401);
        //     }

        //     /*
        //     |--------------------------------------------------------------------------
        //     | Database Query Error (500)
        //     |--------------------------------------------------------------------------
        //     */
        //     if ($e instanceof QueryException) {

        //         Log::error('Database Error', [
        //             'message' => $e->getMessage(),
        //             'sql' => $e->getSql(),
        //             'bindings' => $e->getBindings(),
        //         ]);

        //         return response()->json([
        //             'status' => false,
        //             'message' => trans('default.database_error_response'),
        //             'data' => null,
        //             'errors' => [],
        //         ], 500);
        //     }

        //     /*
        //     |--------------------------------------------------------------------------
        //     | HTTP Exceptions (403, 405, etc.)
        //     |--------------------------------------------------------------------------
        //     */
        //     if ($e instanceof HttpExceptionInterface) {
        //         return response()->json([
        //             'status' => false,
        //             'message' => $e->getMessage() ?: 'HTTP Error',
        //             'data' => null,
        //             'errors' => [],
        //         ], $e->getStatusCode());
        //     }

        //     /*
        //     |--------------------------------------------------------------------------
        //     | General Exception (500)
        //     |--------------------------------------------------------------------------
        //     */

        //     Log::error('Server Error', [
        //         'message' => $e->getMessage(),
        //         'file' => $e->getFile(),
        //         'line' => $e->getLine(),
        //     ]);

        //     return response()->json([
        //         'status' => false,
        //         'message' => config('app.debug')
        //             ? $e->getMessage()
        //             : trans('default.failed_response'),
        //         'data' => null,
        //         'errors' => config('app.debug')
        //             ? ['trace' => $e->getTrace()]
        //             : [],
        //     ], 500);

        // });

    })

    ->create();