<?php

$app->group('/users', function () use ($app) {

  // GET: /users/
  $app->get('/', function () use ($app) {
    $users = UserService::query()->toList();
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
    $user = UserService::findById($id);
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

    $user = $id ? UserService::findById($id) : new User();

    $user->first_name = $request->post('first_name');
    $user->last_name = $request->post('last_name');
    $user->age = (int)$request->post('age');
    $user->email = $request->post('email');

    if ($id) {
      UserService::update($user);
    } else {
      UserService::create($user);
    }

    return $user;
  }
});
