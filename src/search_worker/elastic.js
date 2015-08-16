var http = require('http');
var config = require('./config').elastic;

module.exports = {

  init: function () {

  },

  index: function (type, id, doc) {
    var request = createRequest('PUT', '/search_system/' + type + '/' + id);
    request.write(JSON.stringify(doc));
    request.end();
  },

  remove: function (type, id) {
    var request = createRequest(
      'DELETE', '/search_system/' + type + '/' + id, function (response) {
        response.setEncoding('utf-8');
        var str = '';
        response.on('data', function (chunk) {
          str += chunk;
        });
        response.on('end', function () {
          console.log(str);
        });
      });
    request.end();
  }
};

function createRequest(method, path, callback) {
  var request = http.request({
    host: config.host,
    port: config.port,
    path: path,
    method: method
  }, callback);

  request.on('error', function (e) {
    console.log('Request error:');
    console.log(e);
  });

  return request;
}
