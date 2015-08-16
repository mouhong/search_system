<?php

$GLOBALS['DIR_APP'] = dirname(__DIR__) . '/app';

require '../app/vendor/autoload.php';
require '../app/autoload.php';
require '../app/config.php';

// RabbitMQ
MessageBus::initialize($GLOBALS);

// Slim
$app = new \Slim\Slim([
  'debug' => true,
  'mode' => 'development',
  'templates.path' => '../app/views'
]);

// Register routes
$routes = glob('../app/routes/*.php');
foreach ($routes as $route) {
  require_once $route;
}

$app->run();
