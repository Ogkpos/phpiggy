<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\ValidationException;

class ValidationExceptionMiddleware implements MiddlewareInterface
{
  public function process(callable $next)
  {
    try {
      $next();
    } catch (ValidationException $err) {
      $oldFormData = $_POST;

      //Hide password field in form
      $excludedFields = ['password', 'confirmPassword'];
      $formattedFormData = array_diff_key($oldFormData, array_flip($excludedFields));

      $_SESSION["errors"] = $err->errors;
      //Persist value in form after submission
      // $_SESSION['oldFormData'] = $_POST;
      $_SESSION['oldFormData'] = $formattedFormData;

      $referer = $_SERVER["HTTP_REFERER"];
      // redirectTo("/register");
      redirectTo($referer);
    }
  }
}
