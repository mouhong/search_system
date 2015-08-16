<?php
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MessageQueue {
  public static $channel;

  const SEARCH_SYNC = "search_sync";

  public static function initialize($params) {
    $connection = new AMQPConnection(
      $params['RABBITMQ_HOST'],
      $params['RABBITMQ_PORT'],
      $params['RABBITMQ_USER'],
      $params['RABBITMQ_PWD']
    );

    self::$channel = $connection->channel();

    // Declare queues
    self::$channel->queue_declare(
      self::SEARCH_SYNC,  /* queue */
      false,              /* passive */
      true,               /* durable */
      false,              /* exclusive */
      false               /* auto_delete */
    );
  }

  public static function publish($msg, $queue) {
    $amqp_msg = new AMQPMessage(json_encode($msg));
    self::$channel->basic_publish($amqp_msg, '', $queue);
  }
}
