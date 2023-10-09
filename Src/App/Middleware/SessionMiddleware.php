<?php

declare(strict_types=1);

namespace App\Middleware;


use Framework\Contracts\MiddlewareInterface;

class SessionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {

        if (session_status() === PHP_SESSION_ACTIVE) {
        }
        session_start();


        $next();
    }
}
