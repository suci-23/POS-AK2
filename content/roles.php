<?php
$query = mysqli_query($config, "SELECT * FROM roles ORDER BY id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
// print_r($rows);
?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-tittle mt-3">Data Roles</h5>
        <div class="mb-3" align="right">
          <a href="?page=manage-role" class="btn btn-primary">Add Role</a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Role Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $key => $data): ?>
                <tr>
                  <td><?php echo $key += 1; ?></td>
                  <td><?php echo $data['nm_role'] ?></td>
                  <td>
                    <a href="?page=manage-role&add-role-menu=<?php echo $data['id'] ?>" class="btn btn-success">+ Role
                      Menu</a>
                    <a href="?page=manage-role&edit=<?php echo $data['id'] ?>" class="btn btn-primary">Edit</a>
                    <a onclick="return confirm('Are You Sure...?')"
                      href="?page=manage-role&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
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