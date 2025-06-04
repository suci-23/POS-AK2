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
?>

<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          <!-- Ganti judul di bagian Card Title -->
          <?= isset($_GET['edit']) ? 'Edit Role' : 'Add Role' ?>
        </h5>

        <form action="" method="post">
          <div class="mb-3">
            <label for="">Role Name*</label>
            <input type="text" class="form-control" name="nm_major" placeholder="Enter Role" required
              value="<?= isset($_GET['edit']) ? $rowedit['nm_major'] : ''; ?>">
          </div>
          <div class="mb-3">
            <input type="submit" class="btn btn-success" name="save" value="Save">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>