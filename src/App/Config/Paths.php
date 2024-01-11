<?php

declare(strict_types=1);

namespace App\Config;

class Paths
{
  public const VIEW = __DIR__ . "/../views";
  public const SOURCE = __DIR__ . "/../../";
  //constant for the root directory of our project
  public const ROOT = __DIR__ . "/../../../";

  public const STORAGE_UPLOADS = __DIR__ . "/../../../storage/uploads";
}
