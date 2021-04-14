<?php

use app\Controllers\AuthController;
use app\Controllers\PublicController;
use app\core\Application;

Application::$app->router->post('/api/register', [AuthController::class, 'register']);
Application::$app->router->post('/api/login', [AuthController::class, 'login']);
Application::$app->router->post('/api/logout', [AuthController::class, 'logout']);
