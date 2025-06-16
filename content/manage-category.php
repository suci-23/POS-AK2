<?php

$id_category = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM categories WHERE id='$id_category'");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_GET['delete'])) {
  $id_category = $_GET['delete'];

  //DELETE
  $querydelete = mysqli_query($config, "DELETE FROM categories WHERE id = '$id_category'");

  if ($querydelete) {
    header("location:?page=categories&delete=success");
  } else {
    header("location:?page=categories&delete=failed");
  }
}

if (isset($_POST['nm_category'])) {

  // Ada ga parameter bernama Edit? YES, jalankan perintah EDIT / UPDATE.
  // NO, tambah data baru / INSERT.

  $nm_category = $_POST['nm_category'];

  if (!isset($_GET['edit'])) {
    $queryinsert = mysqli_query($config, "INSERT INTO categories(nm_category) VALUES ('$nm_category')");
    header("location:?page=categories&add=success");
  } else {
    $id_category = isset($_GET['edit']) ? $_GET['edit'] : '';
    $update = mysqli_query($config, "UPDATE categories SET nm_category = '$nm_category' WHERE id = $id_category");
    header("location:?page=categories&edit=success");
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
            <label for="">Category Name*</label>
            <input type="text" class="form-control" name="nm_category" placeholder="Enter Category Name" required
              value="<?= isset($_GET['edit']) ? $rowedit['nm_category'] : ''; ?>">
          </div>
          <div class="mb-3">
            <input type="submit" class="btn btn-success" name="save" value="Save">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>