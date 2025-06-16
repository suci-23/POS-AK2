<?php
$queryshow = mysqli_query($config, "SELECT * FROM categories ORDER BY id DESC");
$rows = mysqli_fetch_all($queryshow, MYSQLI_ASSOC);
// print_r($rows);
?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-tittle mt-3">Data Categories</h5>
        <div class="mb-3" align="right">
          <a href="?page=manage-category" class="btn btn-primary">Add Category</a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered datatable">
            <thead>
              <tr>
                <th>No</th>
                <th>Category Name</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $key => $data): ?>
                <tr>
                  <td><?php echo $key += 1; ?></td>
                  <td><?php echo $data['nm_category'] ?></td>
                  <td>
                    <a href="?page=manage-category&edit=<?php echo $data['id'] ?>" class="btn btn-primary">Edit</a>
                    <a onclick="return confirm('Are You Sure...?')"
                      href="?page=manage-category&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
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