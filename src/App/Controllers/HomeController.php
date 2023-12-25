<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

class HomeController
{
  // private TemplateEngine $view;

  public function __construct(private TemplateEngine $view)
  {
    // $this->view = new TemplateEngine(Paths::VIEW);
  }

  public function home()
  {
    // echo $this->view->render('/index.php', [
    // 'title' => "Home Page"
    // ]);
    echo $this->view->render('/index.php');
  }
}
