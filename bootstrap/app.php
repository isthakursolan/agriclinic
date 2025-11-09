<?php

use App\Http\Middleware\authMiddleware;
use App\Http\Middleware\guestMiddleware;
use App\Http\Middleware\LoadUserRoles;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Apply LoadUserRoles middleware globally to all web routes
        $middleware->web(append: [
            \App\Http\Middleware\LoadUserRoles::class,
        ]);
        
        $middleware->alias([

            // Laravel defaults
            'auth' => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,

            // Your custom middleware
            'auth' => authMiddleware::class,
            'guest' => guestMiddleware::class,

            // Spatie middlewares
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            
            // Custom middlewares
            'load.roles' => LoadUserRoles::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
