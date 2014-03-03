<?php
namespace Controllers\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Silex\Application;

class PeopleController
{
    
    public function index(Application $app)
    {
        return $app['twig']->render('Admin/People/list.twig', array(
            'name' => 'asd',
        ));
    }
    
    public function form(Application $app)
    {
        return $app['twig']->render('Admin/People/form.twig');
    }

}