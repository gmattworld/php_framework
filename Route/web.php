<?php

use app\Controllers\PublicController;
use app\core\Application;

Application::$app->router->get('/', [PublicController::class, 'home']);
Application::$app->router->post('/feedback', [PublicController::class, 'feedback']);
