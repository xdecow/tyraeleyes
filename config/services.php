<?php
declare(strict_types = 1);

// $container = $app->getContainer();

$container->set('viewer', function () {
    $service = new \DViewer\DViewer('../data/d2txt/');
    return $service;
});
