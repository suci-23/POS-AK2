<?php
$queryshow = mysqli_query($config, "SELECT * FROM majors ORDER BY id DESC");
$rows = mysqli_fetch_all($queryshow, MYSQLI_ASSOC);
// print_r($rows);
?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-tittle mt-3">Data Majors</h5>
        <div class="mb-3" align="right">
          <a href="?page=manage-major" class="btn btn-primary">Add Major</a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered datatable">
            <thead>
              <tr>
                <th>No</th>
                <th>Major Name</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $key => $data): ?>
              <tr>
                <td><?php echo $key += 1; ?></td>
                <td><?php echo $data['nm_major'] ?></td>
                <td>
                  <a href="?page=manage-major&edit=<?php echo $data['id'] ?>" class="btn btn-primary">Edit</a>
                  <a onclick="return confirm('Are You Sure...?')"
                    href="?page=manage-major&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
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