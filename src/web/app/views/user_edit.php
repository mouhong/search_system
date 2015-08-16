
  <form action="" method="post" class="form-horizontal">
    <div class="form-group">
      <label class="control-label col-sm-2">Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control"
               name="first_name" placeholder="First name"
               value="<?= $model->first_name ?>" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Email</label>
      <div class="col-sm-10">
        <input type="text" name="email" class="form-control"
               value="<?= $model->email ?>" />
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-10 col-sm-offset-2">
        <button type="submit" class="btn btn-primary btn-lg"><?= $model->id ? 'Update' : 'Create' ?></button>
      </div>
    </div>
  </form>
