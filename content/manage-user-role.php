<?php

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $id_instructor = $_GET['id_instructor'];

  //DELETE
  $querydelete = mysqli_query($config, "DELETE FROM instructor_majors WHERE id = '$id'");

  if ($querydelete) {
    header("location:?page=add-instructor-major&id=" . $id_instructor . "&remove=success");
  } else {
    header("location:?page=add-instructor-major&id=" . $id_instructor . "&remove=failed");
  }
}

$id_instructor1 = isset($_GET['id']) ? $_GET['id'] : '';
$edit = isset($_GET['edit']) ? $_GET['edit'] : '';


if (isset($_POST['id_major'])) {

  // Ada ga parameter bernama Edit? YES, jalankan perintah EDIT / UPDATE.
  // NO, tambah data baru / INSERT.

  $id_major = $_POST['id_major'];

  if (isset($_GET['edit'])) {
    $update = mysqli_query($config, "UPDATE instructor_majors SET id_major = '$id_major' WHERE id='$edit'");
    header("location:?page=add-instructor-major&id=" . $id_instructor1 . "&update=success");
  } else {
    $queryinsert = mysqli_query($config, "INSERT INTO instructor_majors(id_major, id_instructor) VALUES ('$id_major', '$id_instructor1')");
    header("location:?page=add-instructor-major&id=" . $id_instructor1 . "&add=success");
  }
}

$querymajors = mysqli_query($config, "SELECT * FROM majors ORDER BY id DESC");
$rowmajors = mysqli_fetch_all($querymajors, MYSQLI_ASSOC);

$queryinstructor = mysqli_query($config, "SELECT * FROM instructors WHERE id = '$id_instructor1'");
$rowinstructor = mysqli_fetch_assoc($queryinstructor);

$queryinstructormajor = mysqli_query($config, "SELECT majors.nm_major, instructor_majors.id, id_instructor FROM instructor_majors
                        LEFT JOIN majors ON majors.id = instructor_majors.id_major
                        WHERE id_instructor ='$id_instructor1'
                        ORDER BY instructor_majors.id DESC");
$rowinstructormajor = mysqli_fetch_all($queryinstructormajor, MYSQLI_ASSOC);

$queryedit = mysqli_query($config, "SELECT * FROM instructor_majors WHERE id='$edit'");
$rowedit = mysqli_fetch_assoc($queryedit);


?>

<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <!-- Ganti judul EDIT di bagian Card Title -->
        <h5 class="card-title">
          <?= isset($_GET['edit']) ? 'Edit' : 'Add' ?> Instructor Major : <?php echo $rowinstructor['nm_instructor'] ?>
        </h5>
        <!-- Form Edit -->
        <?php if (isset($_GET['edit'])): ?>
          <!-- End Form Edit -->
          <form action="" method="post">
            <div class="modal-body">
              <div class="mb-3">
                <label for="" class="form-label">Major Name</label>
                <select name="id_major" id="" class="form-control">
                  <option value="">Select One</option>
                  <?php foreach ($rowmajors as $rowmajor): ?>
                    <option <?php echo $rowmajor['id'] == $rowedit['id_major'] ? 'selected' : '' ?>
                      value="<?php echo $rowmajor['id'] ?>"><?php echo $rowmajor['nm_major'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="mb-3">
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>

        <?php else: ?>
          <!-- Listing Table -->

          <div align="right">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
              Add Instructor Major
            </button>
          </div>

          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Major Name</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rowinstructormajor as $key => $rowinstructormajors): ?>
                <tr>
                  <td><?php echo $key += 1; ?></td>
                  <td><?php echo $rowinstructormajors['nm_major'] ?></td>
                  <td>
                    <a href="?page=add-instructor-major&id=<?php echo $rowinstructormajors['id_instructor'] ?>&edit=<?php echo $rowinstructormajors['id'] ?>"
                      class="btn btn-primary">Edit</a>
                    <a onclick="return confirm('Are You Sure...?')"
                      href="?page=add-instructor-major&delete=<?php echo $rowinstructormajors['id'] ?>&id_instructor=<?php echo $rowinstructormajors['id_instructor'] ?>"
                      class="btn btn-danger">Delete</a>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        <?php endif ?>

        <!-- Button trigger modal -->

      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class=" modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">+ New Insrtuctor Major : </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="" class="form-label">Major Name</label>
            <select name="id_major" id="" class="form-control">
              <option value="">Select One</option>
              <?php foreach ($rowmajors as $rowmajor): ?>
                <option value="<?php echo $rowmajor['id'] ?>"><?php echo $rowmajor['nm_major'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>

    </div>
  </div>
</div>