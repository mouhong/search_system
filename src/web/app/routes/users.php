<?php

$app->group('/users', function () use ($app) {

  // GET: /users/
  $app->get('/', function () use ($app) {
    $users = Database::repository(User::class)
                     ->query()
                     //->where('email = :email', [ 'email' => 'linmouhong@gmail.com'])
                     ->toList();

    foreach ($users as $user) {
      echo $user->first_name . '<br/>';
    }
  });

  // GET: /users/create
  $app->get('/create', function () use ($app) {
    return $app->render('user_edit.php', [
      'model' => new User()
    ]);
  });

  // POST: /users/create
  $app->post('/create', function () use ($app) {
    $user = user_save($app, NULL);
    $app->redirect($app->urlFor('user_edit', [ 'id' => $user->id ]));
  });

  // GET: /users/:id/edit
  $app->get('/:id/edit', function ($id) use ($app) {
    $db = Database::repository(User::class);
    $user = $db->query()
               ->where('id=:id', [ 'id' => $id ])
               ->first();

    return $app->render('user_edit.php', [
      'model' => $user
    ]);
  })
  ->name('user_edit');

  // POST: /users/:id/edit
  $app->post('/:id/edit', function ($id) use ($app) {
    $user = user_save($app, $id);
    $app->redirect($app->urlFor('user_edit', [ 'id' => $user->id ]));
  });

  function user_save($app, $id) {
    $request = $app->request;

    $db = Database::repository(User::class);
    $user = NULL;

    if ($id) {
      $user = $db->query()->where('id = :id', [ 'id' => $id ])->first();
    } else {
      $user = new User();
    }

    $user->first_name = $request->post('first_name');
    $user->last_name = $request->post('last_name');
    $user->age = (int)$request->post('age');
    $user->email = $request->post('email');

    if ($id) {
      $db->update($user);
    } else {
      $db->create($user);
    }

    return $user;
  }
});
