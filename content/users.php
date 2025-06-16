<?php
$query = mysqli_query($config, "SELECT * FROM users WHERE deleted_at = 0 ORDER BY id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
// print_r($rows);
?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-tittle">Data Users</h5>
        <div class="mb-3 d-flex justify-content-between">
          <a href="?page=manage-user" class="btn btn-primary">Add User</a>
          <a href="?page=restore-user" class="btn btn-primary">Restore</a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered datatable">
            <thead>
              <tr>
                <th>No</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $key => $data): ?>
                <tr>
                  <td><?php echo $key += 1; ?></td>
                  <td><?php echo $data['nm_user'] ?></td>
                  <td><?php echo $data['email'] ?></td>
                  <td>
                    <a href="?page=manage-user&edit=<?php echo $data['id'] ?>" class="btn btn-primary">Edit</a>
                    <a onclick="return confirm('Are You Sure...?')"
                      href="?page=manage-user&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
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