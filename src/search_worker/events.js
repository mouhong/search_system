var consumers = require('./consumers');

var _registry = {};
var _exchange;
var _queue;

module.exports = {
  on: function (key, consumer) {
    var consumers = _registry[key];
    if (!consumers) {
      consumers = [];
      _registry[key] = consumers;

      _queue.bind(_exchange.name, key);
    }

    consumers.push(consumer);
  },
  init: function (exchange, queue) {
    // This module acts as a bridge between RabbitMQ and local event bus
    _exchange = exchange;
    _queue = queue;

    consumers.register(this);
    console.log('Consumers registered');

    queue.subscribe({
      ack: true
    }, function (message, headers, deliveryInfo, ack) {

      var data = JSON.parse(message.data.toString('utf-8'));
      // Invoke consumers
      var consumers = _registry[deliveryInfo.routingKey];
      for (var i = 0, consumer; consumer = consumers[i]; i++) {
        consumer(data.payload);
      }

      ack.acknowledge();
    });
  }
}
