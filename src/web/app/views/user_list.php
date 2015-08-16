
  <div style="margin-bottom:10px">
    <form method="get" action="" class="form-inline text-right">
      <input type="text" name="q" class="form-control" placeholder="Keywords"
             value="<?= $query ?>" />
      <button type="submit" class="btn btn-primary">Search</button>
    </form>
  </div>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Age</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user): ?>
        <tr>
          <td>
            <a href="/users/<?= $user->id ?>/edit">
              <?= $user->first_name ?> <?= $user->last_name ?>
            </a>
          </td>
          <td>
            <?= $user->email ?>
          </td>
          <td>
            <?= $user->age ?>
          </td>
          <td>
            <a href="#" data-toggle="delete-user" data-id="<?= $user->id ?>">Delete</a>
          </td>
        </tr>
      <?php endforeach ?>
      <?php if ($hits->total === 0): ?>
        <tr>
          <td colspan="100" style="padding:30px;text-align:center">
            No records to display
          </td>
        </tr>
      <?php endif; ?>
    </tbody>

  </table>
  <div>
    Total: <?= $hits->total ?>
  </div>

<script>
  $(function () {
    var deleting = false;

    $(document).on('click', '[data-toggle="delete-user"]', function () {
      if (deleting) {
        return false;
      }
      deleting = true;

      $.ajax({
        url: '/users/' + $(this).data('id'),
        type: 'DELETE',
        contentType: 'application/json'
      })
      .done(function () {
        setTimeout(function () {
          deleting = false;
          location.href = '/users/';
        }, 800);
      });

      return false;
    });
  });
</script>
