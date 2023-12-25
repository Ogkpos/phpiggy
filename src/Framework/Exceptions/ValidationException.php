<?php

declare(strict_types=1);

namespace Framework\Exceptions;

use RuntimeException;

class ValidationException extends RuntimeException
{
  public function __construct(public array $errors, int $code = 422)
  {
    //invoke the parent construct method
    parent::__construct(code: $code);
  }
}
