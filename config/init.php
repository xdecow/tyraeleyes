<?php
declare(strict_types = 1);

use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

function debug($var, $exit = true) {
    print('<pre class="debug">');
    print_r($var);
    print('</pre>');

    if ($exit) {
        exit('end from debug');
    }
}


// Create Twig
$twig = Twig::create('../views/', ['cache' => false]);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

