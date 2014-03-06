<?php
namespace Controllers\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Silex\Application;

class DashboardController
{
    
    public function index(Application $app)
    {
        return $app['twig']->render('dashboard.twig', array(
            'name' => 'asd',
        ));
    }
    
}