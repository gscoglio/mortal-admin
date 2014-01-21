<?php
$loader = require __DIR__ . '/../vendor/autoload.php';

$loader->add('Providers', __DIR__ .'/../src/');
$loader->add('Controllers', __DIR__ .'/../src/');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app['debug'] = true;

$app->register(
    new Providers\ConfigServiceProvider(__DIR__ . "/config/config.yml")
);
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/Views',
));

$admin = $app['controllers_factory'];
$admin->get('/', 'Controllers\Admin\LoginController::form');
$admin->get('/people', 'Controllers\Admin\PeopleController::index');
$admin->get('/people/add', 'Controllers\Admin\People::form');
$admin->get('/people/edit/{id}', 'Controllers\Admin\People::form');

$app->mount('/admin', $admin);

return $app;