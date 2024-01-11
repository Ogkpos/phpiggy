<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;

//Validating CSRF tokens
class CsrfGuardMiddleware implements MiddlewareInterface
{
  public function process(callable $next)
  {
    $requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
    $validMethods = ['POST', 'PATCH', 'DELETE'];

    //check token for each of the http methods
    if (!in_array($requestMethod, $validMethods)) {
      $next();
      return;
    }

    //check if token from submission does not match token submitted with the form
    if ($_SESSION['token'] !== $_POST['token']) {
      redirectTo('/');
    }

    //DEstroying the token
    unset($_SESSION['token']);

    $next();
  }
}
