var amqp = require('amqp');
var consumer = require('./consumer').consumer;

var config = {
  host: 'localhost',
  port: 5672,
  login: 'guest',
  password: 'guest',
  queueName: 'search_sync'
};

var connection = amqp.createConnection({
  host: config.host,
  port: config.port,
  login: config.login,
  password: config.password
});

connection.on('ready', function () {
  var options = {
    durable: true,
    autoDelete: false
  };

  connection.queue(config.queueName, options, function (queue) {
    console.log('Search worker started. Waiting for messages...');

    queue.bind('#');

    queue.subscribe({
      ack: true
    }, function (message, headers, deliveryInfo, ack) {
      var body = message.data.toString('utf-8');
      console.log('Message arrived:');
      console.log(body);

      consumer(JSON.parse(body));

      ack.acknowledge();
    });
  });
});

connection.on('error', function (e) {
  console.log('Connection error:');
  console.log(e);
})
