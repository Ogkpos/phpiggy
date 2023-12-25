<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;


class AboutController
{
  // private TemplateEngine $view;
  public function __construct(private TemplateEngine $view)
  {
    // $this->view = new TemplateEngine(paths::VIEW);
  }
  public function about()
  {
    echo $this->view->render('/about.php', [
      "title" => "About Page",
      "dangerousData" => "<script>alert(123)</script>"
    ]);
  }
}
