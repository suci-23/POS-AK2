<?php

$id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
$querysoft = mysqli_query($config, "SELECT * FROM users WHERE deleted_at = 1 ORDER BY id DESC");
$rows = mysqli_fetch_all($querysoft, MYSQLI_ASSOC);

if (isset($_GET['restore'])) {
  $idrestore = $_GET['restore'];
  $queryrestore = mysqli_query($config, "UPDATE users SET deleted_at = 0 WHERE id = $idrestore");
  if ($queryrestore) {
    header("location:?page=users&recovery=success");
  }
}
if (isset($_GET['delete'])) {
  $iddelete = $_GET['delete'];

  $querydelete = mysqli_query($config, "DELETE FROM users WHERE id = $iddelete");
  if ($querydelete) {
    header("location:?page=users&remove=success");
  }
}

?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Data User</h5>
        <div class="mb-3 d-flex justify-content-between">
          <a href="?page=user" class="btn btn-secondary">Back</a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Full Name</th>
                <th>Email</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $index => $row): ?>
                <tr>
                  <td><?php echo $index += 1; ?></td>
                  <td><?php echo $row['nm_user'] ?></td>
                  <td><?php echo $row['email'] ?></td>
                  <td>
                    <a href="?page=restore-user&restore=<?php echo $row['id'] ?>" class="btn btn-primary">Restore</a>
                    <a onclick="return confirm('Are You Sure...?')"
                      href="?page=restore-user&delete=<?php echo $row['id'] ?>" class="btn btn-danger">Delete</a>

                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>