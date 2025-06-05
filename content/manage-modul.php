<?php

$id_major = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM majors WHERE id='$id_major'");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_GET['delete'])) {
  $id_major = $_GET['delete'];

  //DELETE
  $querydelete = mysqli_query($config, "DELETE FROM majors WHERE id = '$id_major'");

  if ($querydelete) {
    header("location:?page=majors&delete=success");
  } else {
    header("location:?page=majors&delete=failed");
  }
}

if (isset($_POST['nm_major'])) {

  // Ada ga parameter bernama Edit? YES, jalankan perintah EDIT / UPDATE.
  // NO, tambah data baru / INSERT.

  $nm_major = $_POST['nm_major'];

  if (!isset($_GET['edit'])) {
    $queryinsert = mysqli_query($config, "INSERT INTO majors(nm_major) VALUES ('$nm_major')");
    header("location:?page=majors&add=success");
  } else {
    $id_major = isset($_GET['edit']) ? $_GET['edit'] : '';
    $update = mysqli_query($config, "UPDATE majors SET nm_major = '$nm_major' WHERE id = $id_major");
    header("location:?page=majors&edit=success");
  }
}

$id_instructor = isset($_SESSION['ID_USER']) ? $_SESSION['ID_USER'] : '';
$queryinstructormajor = mysqli_query($config, "SELECT majors.nm_major, instructor_majors.*
                                    FROM instructor_majors LEFT JOIN majors ON majors.id = instructor_majors.id_major
                                    WHERE instructor_majors.id_instructor = '$id_instructor'");

$rowinstructormajors = mysqli_fetch_all($queryinstructormajor, MYSQLI_ASSOC);
?>

<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          <!-- Ganti judul di bagian Card Title -->
          <?= isset($_GET['edit']) ? 'Edit Modul' : 'Add Modul' ?>
        </h5>

        <form action="" method="post">
          <div class="row">
            <div class="col-sm-6">
              <div class="mb-3">
                <label for="" class="form-label">Instructor Name*</label>
                <input readonly value="<?php echo $_SESSION['NAME'] ?>" type="text" class="form-control">
                <input type="hidden" name="id_instructor" value="<?php echo $_SESSION['ID_USER'] ?>">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="mb-3">
                <label for="" class="form-label">Major Name</label>
                <select name="id_major" id="" class="form-control">
                  <option value="">Select One</option>
                  <?php foreach ($rowinstructormajors as $row): ?>
                    <option value="<?php echo $row['id_major'] ?>"><?php echo $row['nm_major'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <input type="submit" class="btn btn-success" name="save" value="Save">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>