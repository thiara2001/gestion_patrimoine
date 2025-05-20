<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
<<<<<<< HEAD
use Illuminate\Http\Middleware\TrustProxies as Middleware;
class Kernel extends HttpKernel
{
    /**
     * Les middleware globaux qui sont exécutés lors de chaque requête.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // Middleware global
       // \App\Http\Middleware\TrustProxies::class,
         \Illuminate\Http\Middleware\HandleCors::class,      
          // \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
       // \App\Http\Middleware\TrimStrings::class,
=======

class Kernel extends HttpKernel
{
    /**
     * Global HTTP middleware stack.
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
>>>>>>> c530ec14f7a88e7e7107b305514ce64b621c72fc
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
<<<<<<< HEAD
     * Les groupes de middleware.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
           // \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class, // optionnel
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
           // \App\Http\Middleware\VerifyCsrfToken::class,
=======
     * Middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
>>>>>>> c530ec14f7a88e7e7107b305514ce64b621c72fc
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
<<<<<<< HEAD
             'throttle:api',
              \Illuminate\Routing\Middleware\SubstituteBindings::class,
=======
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
>>>>>>> c530ec14f7a88e7e7107b305514ce64b621c72fc
        ],
    ];

    /**
<<<<<<< HEAD
     * Middleware assignables aux routes.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
=======
     * Route middleware.
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'role' => \App\Http\Middleware\RoleMiddleware::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
>>>>>>> c530ec14f7a88e7e7107b305514ce64b621c72fc
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
