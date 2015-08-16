
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

          </td>
        </tr>
      <?php endforeach ?>
    </tbody>

  </table>
  <div>
    Total: <?= $hits->total ?>
  </div>
