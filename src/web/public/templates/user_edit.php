<?php
?>
<html>
  <body>
    <form action="" method="post">
      <input type="hidden" value="<?= $model->id ?>" />
      Name:
      <input type="text" name="first_name" placeholder="First name" value="<?= $model->first_name ?>" />
      <input type="text" name="last_name" placeholder="Last name" value="<?= $model->last_name ?>" />
      <br/>
      Email: <input type="text" name="email" value="<?= $model->email ?>" />
      <br/>
      Age: <input type="text" name="age" value="<?= $model->age ?>" />
      <br/>
      <button type="submit"><?= $model->id ? 'Update' : 'Create' ?></button>
    </form>
  </body>
</html>
