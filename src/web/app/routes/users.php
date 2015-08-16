<?php

$app->group('/users', function () use ($app) {

  // GET: /users/
  $app->get('/', function () use ($app) {
    $hits = Elastic::search('user');
    $users = array_map(function ($hit) {
      return $hit->_source;
    }, $hits->hits);

    render('user_list.php', [
      'title'       => 'Users',
      'hits'        => $hits,
      'users'       => $users,
      'active_menu' => 'users'
    ]);
  });

  // GET: /users/create
  $app->get('/create', function () use ($app) {
    render('user_edit.php', [
      'model'       => new User(),
      'title'       => 'Create user',
      'active_menu' => 'create'
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
    render('user_edit.php', [
      'model'       => $user,
      'title'       => 'Edit user',
      'active_menu' => 'create'
    ]);
  })
  ->name('user_edit');

  // POST: /users/:id/edit
  $app->post('/:id/edit', function ($id) use ($app) {
    $user = user_save($app, $id);
    $app->redirect($app->urlFor('user_edit', [ 'id' => $user->id ]));
  });

  /**
  * Render a view with default layout
  * TODO: Use a better template engine
  */
  function render($view, $data) {
    global $app;
    $data['view'] = $view;
    $app->render('layout.php', $data);
  }

  /**
  * Create or update a user
  */
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
