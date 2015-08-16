var http = require('http');
var elastic = require('./elastic');

module.exports = {
  register: function (events) {

    events.on('UserCreated', function (event) {
      console.log('Receive event: UserCreated');
      elastic.index('user', event.user.id, event.user);
    });

    events.on('UserUpdated', function (event) {
      console.log('Receive event: UserUpdated');
      elastic.index('user', event.user.id, event.user);
    });

    events.on('UserDeleted', function (event) {
      console.log('Receive event: UserDeleted');
      elastic.remove(event.userId);
    });
    
  }
};
