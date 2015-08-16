var http = require('http');
var config = require('./config').elastic;

module.exports = {

  init: function () {
    
  },

  index: function (type, id, doc) {
    var request = http.request({
      host: config.host,
      port: config.port,
      path: '/search_system/' + type + '/' + id,
      method: 'PUT'
    });

    request.on('error', function (e) {
      console.log('Cannot put document to elastic search:');
      console.log(e);
    });

    request.write(JSON.stringify(doc));
    request.end();
  },

  remove: function (type, id) {
    var request = http.request({
      host: config.host,
      port: config.port,
      path: '/search_system/' + type + '/' + id,
      method: 'DELETE'
    });
    request.end();
  }
};
