<?php

// TODO: Is there a better practise to store them?
$GLOBALS['DB_DSN']        = 'mysql:host=localhost;dbname=search_system';
$GLOBALS['DB_USER_NAME']  = 'root';
$GLOBALS['DB_PWD']        = NULL;

$GLOBALS['RABBITMQ_HOST'] = 'localhost';
$GLOBALS['RABBITMQ_PORT'] = 5672;
$GLOBALS['RABBITMQ_USER'] = 'guest';
$GLOBALS['RABBITMQ_PWD']  = 'guest';

$GLOBALS['ELASTIC_HOST']  = 'localhost';
$GLOBALS['ELASTIC_PORT']  = 9200;

date_default_timezone_set('UTC');
