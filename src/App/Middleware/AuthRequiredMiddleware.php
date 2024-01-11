<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;

//Restricting users from pages that require authentication

class AuthRequiredMiddleware implements MiddlewareInterface
{
  public function process(callable $next)
  {
    //Empty is to verify a variable has no value
    //the session[user] variable only becomes available after a user logs in
    if (empty($_SESSION['user'])) {
      redirectTo('/login');
    }

    $next();
  }
}
