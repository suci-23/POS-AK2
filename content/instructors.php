<?php
$queryshow = mysqli_query($config, "SELECT * FROM instructors ORDER BY id DESC");
$rows = mysqli_fetch_all($queryshow, MYSQLI_ASSOC);
// print_r($rows);
?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-tittle mt-3">Data Instructors</h5>
        <div class="mb-3" align="right">
          <a href="?page=manage-instructor" class="btn btn-primary">Add Instructor</a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered datatable">
            <thead>
              <tr>
                <th>No</th>
                <th>Instructor Name</th>
                <th>Gender</th>
                <th>Education</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $key => $data): ?>
              <tr>
                <td><?php echo $key += 1; ?></td>
                <td><?php echo $data['nm_instructor'] ?></td>
                <td><?php echo $data['gender'] == 1 ? 'Male' : 'Female' ?></td>
                <td><?php echo $data['education'] ?></td>
                <td><?php echo $data['email'] ?></td>
                <td><?php echo $data['phone'] ?></td>
                <td><?php echo $data['address'] ?></td>
                <td>
                  <a href="?page=add-instructor-major&id=<?php echo $data['id'] ?>" class="btn btn-warning">Add
                    Major</a>
                  <a href="?page=manage-instructor&edit=<?php echo $data['id'] ?>" class="btn btn-primary">Edit</a>
                  <a onclick="return confirm('Are You Sure...?')"
                    href="?page=manage-instructor&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
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