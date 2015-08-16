<?php

/**
* Represents a facade for user operations
*/
class UserService {

  public static function findById($id) {
    $repo = Database::repository(User::class);
    return $repo->query()
                ->where('id=:id', ['id' => $id])
                ->first();
  }

  public static function query() {
    return Database::repository(User::class)->query();
  }

  public static function create($user) {
    $repo = Database::repository(User::class);
    $repo->create($user);

    // TODO: Might fail here
    $msg = new SearchSyncMessage();
    $msg->action = 'add';
    $msg->doc = $user;
    $msg->docId = $user->id;
    MessageQueue::publish($msg, MessageQueue::SEARCH_SYNC);
  }

  public static function update($user) {
    $repo = Database::repository(User::class);
    $repo->update($user);

    // TODO: Might fail here
    $msg = new SearchSyncMessage();
    $msg->action = 'update';
    $msg->doc = $user;
    $msg->docId = $user->id;
    MessageQueue::publish($msg, MessageQueue::SEARCH_SYNC);
  }

  public static function delete($id) {
    $repo = Database::repository(User::class);
    $repo->delete($id);

    // TODO: Might fail here
    $msg = new SearchSyncMessage();
    $msg->action = 'delete';
    $msg->docId = $id;
    MessageQueue::publish($msg, MessageQueue::SEARCH_SYNC);
  }
}
