<html>
<body>
  <div>
    <?php foreach ($users as $user): ?>
      <div>
        <?= $user->first_name ?> <?= $user->last_name ?><br/>
        <?= $user->email ?> (<?= $user->age ?>)
      </div>
    <?php endforeach ?>
  </div>
  <div>
    Total: <?= $hits->total ?>
  </div>
</body>
</html>
