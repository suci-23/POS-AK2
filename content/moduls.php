<?php
$id_user = isset($_SESSION['ID_USER']) ? $_SESSION['ID_USER'] : '';
$id_role = isset($_SESSION['ID_ROLE']) ? $_SESSION['ID_ROLE'] : '';
// print_r($id_role);
// die;
$rowstudent = mysqli_fetch_assoc(mysqli_query($config, "SELECT * FROM students WHERE id = '$id_user'"));
$id_major = isset($rowstudent['id_major']) ? $rowstudent['id_major'] : '';

if ($id_role == 3) {
  $where = "WHERE moduls.id_major = '$id_major'";
} elseif ($id_role == 2) {
  $where = "WHERE moduls.id_instructor = '$id_user";
}

$query = mysqli_query($config, "SELECT majors.nm_major, instructors.nm_instructor, moduls.* 
                      FROM moduls
                      LEFT JOIN majors ON majors.id = moduls.id_major
                      LEFT JOIN instructors ON instructors.id = moduls.id_instructor $where
                      -- WHERE moduls.id_instructor = '$id_user
                      ORDER BY moduls.id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
// print_r($rows);
?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-tittle">Data Moduls</h5>
        <?php if (canaddmodul(4)): ?>
          <div class="mb-3" align="right">
            <a href="?page=manage-modul" class="btn btn-primary">Add Modul</a>
          </div>
        <?php endif ?>
        <div class="table-responsive">
          <table class="table table-bordered datatable">
            <thead>
              <tr>
                <th>No</th>
                <th>Title</th>
                <th>Instructor</th>
                <th>Major</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $key => $data): ?>
                <tr>
                  <td><?php echo $key += 1; ?></td>
                  <td><a href="?page=manage-modul&detail=<?php echo $data['id'] ?>">
                      <i class="bi bi-link"></i>
                      <?php echo $data['nm_modul'] ?>
                    </a>
                  </td>
                  <td><?php echo $data['nm_instructor'] ?></td>
                  <td><?php echo $data['nm_major'] ?></td>
                  <td>
                    <?php if ($id_role == 1): ?>
                      <a href="?page=manage-modul&edit=<?php echo $data['id'] ?>" class="btn btn-primary">Edit</a>
                      <a onclick="return confirm('Are You Sure...?')"
                        href="?page=manage-modul&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
                    <?php endif ?>
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