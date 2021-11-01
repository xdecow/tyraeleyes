<?php
declare(strict_types = 1);

chdir(dirname(__FILE__));

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new \DI\Container();
AppFactory::setContainer($container);

$app = AppFactory::create();

require_once('../config/init.php');
require_once('../config/services.php');
require_once('../config/routes.php');

$app->run();