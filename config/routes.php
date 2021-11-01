<?php
declare(strict_types = 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

$container = $app->getContainer();

$app->get('/', function (Request $request, Response $response, $args) use ($container) {

    /* @var $viewer /DViewer/DViewer */
    $viewer = $container->get('viewer');
    $files = $viewer->getFiles();

    $view = Twig::fromRequest($request);
    return $view->render($response, 'index.twig', ['files' => $files]);
    return $response;
});

$app->get('/view/{fname}', function (Request $request, Response $response, $args) use ($container) {

    /* @var $viewer /DViewer/DViewer */
    $viewer = $container->get('viewer');
    $fname = $args['fname'];

    $data = $viewer->getFile($fname);
    $header = $data['header'];
    $rows = $data['rows'];
    
    $view = Twig::fromRequest($request);
    return $view->render($response, 'view.twig', ['fname' => $fname, 'rows' => $rows, 'header' => $header]);
    return $response;
});