<?php
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MessageBus {
  public static $channel;

  const EXCHANGE_NAME = "search_system";

  public static function initialize($params) {
    $connection = new AMQPConnection(
      $params['RABBITMQ_HOST'],
      $params['RABBITMQ_PORT'],
      $params['RABBITMQ_USER'],
      $params['RABBITMQ_PWD']
    );

    self::$channel = $connection->channel();

    self::$channel->exchange_declare(
      self::EXCHANGE_NAME,  /* exchange name */
      'direct',         /* type */
      false,            /* passive */
      true,             /* durable */
      false             /* auto_delete */
    );
  }

  public static function publish($msg) {
    $amqp_msg = new AMQPMessage(json_encode($msg));
    self::$channel->basic_publish($amqp_msg, self::EXCHANGE_NAME, get_class($msg));
  }
}
