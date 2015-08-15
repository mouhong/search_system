<?php
require '../app/vendor/autoload.php';

$app = new \Slim\Slim();

$app->get('/', function () {
  echo 'Hello PHP';
});

$app->run();
