<?php

    require_once __DIR__.'/../vendor/autoload.php';
    use app\core\Application;

    $app = new Application(dirname(__DIR__));

    $app->router->get('/', 'home');
    $app->router->get('/register', 'register');
    $app->router->get('/login', 'login');
    $app->router->get('/logout', 'logout');

    $app->run();