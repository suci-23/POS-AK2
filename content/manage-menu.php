<?php

$id_menu = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM menus WHERE id='$id_menu'");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_GET['delete'])) {
  $id_menu = $_GET['delete'];

  //QUERY DELETE
  $querydelete = mysqli_query($config, "DELETE FROM menus WHERE id = '$id_menu'");

  if ($querydelete) {
    header("location:?page=menus&delete=success");
  } else {
    header("location:?page=menus&delete=failed");
  }
}

if (isset($_POST['nm_menu'])) {

  // Ada ga parameter bernama Edit? YES, jalankan perintah EDIT / UPDATE.
  // NO, tambah data baru / INSERT.

  $nm_menu = $_POST['nm_menu'];
  $parent_id = $_POST['parent_id'];
  $icon = $_POST['icon'];
  $url = $_POST['url'];
  $urutan = $_POST['urutan'];

  if (!isset($_GET['edit'])) {
    $queryinsert = mysqli_query($config, "INSERT INTO menus (nm_menu, parent_id, icon, url, urutan) VALUES ('$nm_menu', '$parent_id', '$icon', '$url', '$urutan')");
    header("location:?page=menus&add=success");
  } else {
    $id_role = isset($_GET['edit']) ? $_GET['edit'] : '';
    $update = mysqli_query($config, "UPDATE roles SET nm_menu = '$nm_menu', parent_id = '$parent_id', icon = '$icon', url = '$url', urutan = '$urutan' WHERE id = $id_menu");
    header("location:?page=menus&edit=success");
  }
}

$queryparentid = mysqli_query($config, "SELECT * FROM menus WHERE parent_id = 0 OR parent_id= ''");
$rowparentid = mysqli_fetch_all($queryparentid, MYSQLI_ASSOC);
?>

<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          <!-- Ganti judul di bagian Card Title -->
          <?= isset($_GET['edit']) ? 'Edit Menu' : 'Add Menu' ?>
        </h5>

        <form action="" method="post">
          <div class="mb-3">
            <label for="">Menu Name*</label>
            <input type="text" class="form-control" name="nm_menu" placeholder="Enter Menu Name" required
              value="<?= isset($_GET['edit']) ? $rowedit['nm_menu'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="">Parent ID</label>
            <select name="parent_id" id="" class="form-control">
              <option value="">Select One</option>
              <?php foreach ($rowparentid as $item => $parentid): ?>
                <option value="<?php echo $parentid['nm_menu'] ?>"><?php echo $parentid['nm_menu'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="">Icon*</label>
            <input type="text" class="form-control" name="icon" placeholder="Enter Icon Menu" required
              value="<?= isset($_GET['icon']) ? $rowedit['icon'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="">URL</label>
            <input type="text" class="form-control" name="url" placeholder="Enter URL Menu"
              value="<?= isset($_GET['url']) ? $rowedit['url'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="">Order</label>
            <input type="number" class="form-control" name="urutan" placeholder="Enter Order Menu"
              value="<?= isset($_GET['urutan']) ? $rowedit['urutan'] : ''; ?>">
          </div>
          <div class="mb-3">
            <input type="submit" class="btn btn-success" name="save" value="Save">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>