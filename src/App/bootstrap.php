<?php

declare(strict_types=1);

// include __DIR__ . "/../Framework/App.php";
require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use Dotenv\Dotenv;
// use App\Controllers\{HomeController, AboutController};
use function App\Config\{registerRoutes, registerMiddleware};
use App\Config\Paths;

//Loading .env variables
$dotenv = Dotenv::createImmutable(Paths::ROOT);
$dotenv->load();




$app = new App(Paths::SOURCE . "app/container-definitions.php");

//Registering the controller
// $app->get('/',['App\Controllers\HomeController','home']);

// $app->get('/', [HomeController::class, 'home']);
// $app->get('/about', [AboutController::class, 'about']);
registerRoutes($app);
registerMiddleware($app);

// $app->get('about/team');
// $app->get('/about/team');
// $app->get('/about/team/');

// dd($app);
return $app;
