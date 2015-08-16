module.exports = {
  register: function (events) {

    events.on('UserCreated', function (event) {
      console.log('created');
    });

    events.on('UserUpdated', function (event) {
      console.log('updated');
    });

    events.on('UserDeleted', function (event) {
      console.log('deleted');
    });

  }
};
