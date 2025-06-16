<?php
$query = mysqli_query($config, "SELECT * FROM menus ORDER BY id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
// print_r($rows);
?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-tittle mt-3">Data Menus</h5>
        <div class="mb-3" align="right">
          <a href="?page=manage-menu" class="btn btn-primary">Add Menu</a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Menu Name</th>
                <th>Parent ID</th>
                <th>Icon</th>
                <th>URL</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $key => $data): ?>
                <tr>
                  <td><?php echo $key += 1; ?></td>
                  <td><?php echo $data['nm_menu'] ?></td>
                  <td><?php echo $data['parent_id'] ?></td>
                  <td><?php echo $data['icon'] ?></td>
                  <td><?php echo $data['url'] ?></td>
                  <td>
                    <a href="?page=manage-menu&edit=<?php echo $data['id'] ?>" class="btn btn-primary">Edit</a>
                    <a onclick="return confirm('Are You Sure...?')"
                      href="?page=manage-menu&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
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