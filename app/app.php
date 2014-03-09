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

$app->register(new Silex\Provider\SecurityServiceProvider());


$app['security.firewalls'] = array(
    'admin' => array(
        'pattern' => '^/',
        'http' => true,
        'users' => array(
            // raw password is foo
            'ale' => array('ROLE_ADMIN', 'dVU2sZFLXrtFaePZ5srMbYJXPQ8QtbQUMFPlfJFpQROiR846+HyNrmrIN8cx/toJl7OaIU5Rdj3XgvKSdgMmyQ=='),
        ),
    ),
);

$login = $app['controllers_factory'];
$login->get('/', 'Controllers\Admin\DashboardController::index');

$people = $app['controllers_factory'];
$people->get('/', 'Controllers\Admin\PeopleController::index');
$people->get('/add', 'Controllers\Admin\PeopleController::form');
$people->get('/edit/{id}', 'Controllers\Admin\PeopleController::form');

$app->mount('/', $login);
$app->mount('/people', $people);

return $app;