
  <form action="" method="post" class="form-horizontal">
    <div class="form-group">
      <label class="control-label col-sm-2">Name</label>
      <div class="col-sm-5">
        <div class="form-inline">
          <input type="text" class="form-control" style="width:150px"
                 name="first_name" placeholder="First name"
                 value="<?= $model->first_name ?>" />
          <input type="text" class="form-control" style="width:150px"
                 name="last_name" placeholder="Last name"
                 value="<?= $model->last_name ?>" />
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Email</label>
      <div class="col-sm-5">
        <input type="text" name="email" class="form-control"
               value="<?= $model->email ?>" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Age</label>
      <div class="col-sm-5">
        <input type="text" name="age" class="form-control"
               value="<?= $model->age ?>" />
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-5 col-sm-offset-2">
        <button type="submit" class="btn btn-primary btn-lg"><?= $model->id ? 'Update' : 'Create' ?></button>
      </div>
    </div>
  </form>
