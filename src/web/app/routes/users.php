<?php

$app->group('/users', function () use ($app) {

  // GET: /users/
  $app->get('/', function () use ($app) {
    $users = Database::repository(User::class)
                     ->query()
                     ->where('email = :email', [ 'email' => 'linmouhong@gmail.com'])
                     ->toList();

    foreach ($users as $user) {
      echo $user->first_name . '<br/>';
    }
  });

  // GET: /users/create
  $app->get('/create', function () use ($app) {

    $user = new User();
    $user->first_name = 'John';
    $user->last_name = 'You';
    $user->age = 33;
    $user->email = 'john@gmail.com';

    Database::repository(User::class)
            ->create($user);

    echo 'OK';
  });

  // POST: /users/save
  $app->post('/save', function () use ($app) {
    echo 'OK';
  });

  $app->get('/:id/edit', function ($id) use ($app) {
    echo "Edit user {$id}";
  });

});
