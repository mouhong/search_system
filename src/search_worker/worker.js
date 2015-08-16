var amqp = require('amqp');
var events = require('./events');

var config = {
  host: 'localhost',
  port: 5672,
  login: 'guest',
  password: 'guest'
};

var connection = amqp.createConnection({
  host: config.host,
  port: config.port,
  login: config.login,
  password: config.password
});

var EXCHANGE_NAME = 'search_system';

connection.on('ready', function () {
  var queueOpts = {
    durable: true,
    autoDelete: false
  };

  connection.queue('search_system_sync', queueOpts, function (queue) {

    var exchangeOpts = {
      type: 'direct',
      durable: true,
      autoDelete: false
    };

    connection.exchange(EXCHANGE_NAME, exchangeOpts, function (exchange) {
      console.log('Exchange ready');
      events.init(exchange, queue);
    });

  });
});

connection.on('error', function (e) {
  console.log('Connection error:');
  console.log(e);
})
