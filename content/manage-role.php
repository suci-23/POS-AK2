<?php

$id_role = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM roles WHERE id='$id_role'");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_GET['delete'])) {
  $id_role = $_GET['delete'];

  //QUERY DELETE
  $querydelete = mysqli_query($config, "DELETE FROM roles WHERE id = '$id_role'");

  if ($querydelete) {
    header("location:?page=roles&delete=success");
  } else {
    header("location:?page=roles&delete=failed");
  }
}

if (isset($_POST['nm_role'])) {

  // Ada ga parameter bernama Edit? YES, jalankan perintah EDIT / UPDATE.
  // NO, tambah data baru / INSERT.

  $nm_role = $_POST['nm_role'];

  if (!isset($_GET['edit'])) {
    $queryinsert = mysqli_query($config, "INSERT INTO roles(nm_role) VALUES ('$nm_role')");
    header("location:?page=roles&add=success");
  } else {
    $id_role = isset($_GET['edit']) ? $_GET['edit'] : '';
    $update = mysqli_query($config, "UPDATE roles SET nm_role = '$nm_role' WHERE id = $id_role");
    header("location:?page=roles&edit=success");
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
            <input type="text" class="form-control" name="nm_role" placeholder="Enter Role" required
              value="<?= isset($_GET['edit']) ? $rowedit['nm_role'] : ''; ?>">
          </div>
          <div class="mb-3">
            <input type="submit" class="btn btn-success" name="save" value="Save">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>