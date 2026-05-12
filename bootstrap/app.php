<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckSubscription;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;

return Application::configure(basePath: dirname(__DIR__))

    // Routes
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    // Middleware
    ->withMiddleware(function (Middleware $middleware) {
        // You can register global middleware here if needed        
        $middleware->alias([
            'auth' => Authenticate::class,
            'check.subscription' => CheckSubscription::class,
        ]);
    })

    // Global Exception Handling
    ->withExceptions(function (Exceptions $exceptions) {

        // when try to hit api endpoint fron browser
        // $exceptions->render(function (AuthenticationException $e, $request) {
        //     if ($request->is('api/*') || $request->expectsJson()) {
        //         return response()->json([U
        //             'success' => false,
        //             'message' => 'Authentication required.'
        //         ], 401);
        //     }
        // });

    })

    ->create();