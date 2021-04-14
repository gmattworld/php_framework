<?php

    use app\core\Application;

    require_once __DIR__.'/../vendor/autoload.php';


    $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
    $config = [
        'db' => [
            'dsn' => $_ENV['DB_DSN'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
        ]
    ];

    $app = new Application(dirname(__DIR__), $config);

    require_once __DIR__.'/../Route/web.php';
    require_once __DIR__.'/../Route/api.php';

    $app->run();