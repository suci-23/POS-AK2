<?php
$query = mysqli_query($config, "SELECT majors.nm_major, instructors.nm_instructor, moduls.* 
                      FROM moduls
                      LEFT JOIN majors ON majors.id = moduls.id_major
                      LEFT JOIN instructors ON instructors.id = moduls.id_instructor
                      ORDER BY moduls.id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
// print_r($rows);
?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-tittle">Data Moduls</h5>
        <div class="mb-3" align="right">
          <a href="?page=manage-modul" class="btn btn-primary">Add Modul</a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered datatable">
            <thead>
              <tr>
                <th>No</th>
                <th>Instructor</th>
                <th>Major</th>
                <th>Title</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $key => $data): ?>
                <tr>
                  <td><?php echo $key += 1; ?></td>
                  <td><?php echo $data['nm_instructor'] ?></td>
                  <td><?php echo $data['nm_major'] ?></td>
                  <td><?php echo $data['nm_modul'] ?></td>
                  <td>
                    <a href="?page=manage-modul&edit=<?php echo $data['id'] ?>" class="btn btn-primary">Edit</a>
                    <a onclick="return confirm('Are You Sure...?')"
                      href="?page=manage-modul&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
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