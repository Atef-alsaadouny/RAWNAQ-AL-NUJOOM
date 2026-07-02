<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\SecurityHeaders::class,
        ]);

        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        $middleware->trustProxies(at: env('TRUSTED_PROXIES', '*'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->dontReport([
            \Illuminate\Auth\AuthenticationException::class,
            \Illuminate\Auth\Access\AuthorizationException::class,
            \Symfony\Component\HttpKernel\Exception\HttpException::class,
            \Illuminate\Database\Eloquent\ModelNotFoundException::class,
            \Illuminate\Validation\ValidationException::class,
        ]);

        // معالجة خاصة لـ TokenMismatchException (419)
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Session expired'], 419);
            }
            return redirect()->back()->withInput()->with('error', __('Session expired. Please refresh and try again.'));
        });

        // معالجة خاصة لـ ModelNotFoundException (404)
        $exceptions->render(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Resource not found'], 404);
            }
            return redirect()->back()->with('error', __('Resource not found.'));
        });

        // كل الأخطاء الأخرى ترجع لنفس الصفحة مع رسالة بدل صفحة خطأ منفصلة
        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return null;
            }

            $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : (method_exists($e, 'getCode') && $e->getCode() >= 400 ? $e->getCode() : 500);

            $messages = [
                403 => __('You do not have permission to perform this action.'),
                404 => __('Page not found.'),
                419 => __('Session expired. Please refresh and try again.'),
                429 => __('Please wait a moment before trying again.'),
            ];

            $message = $messages[$statusCode] ?? __('Something went wrong. Please try again.');

            if ($statusCode >= 400 && $statusCode < 500) {
                return redirect()->back()->with('error', $message);
            }

            return null;
        });
    })->create();
