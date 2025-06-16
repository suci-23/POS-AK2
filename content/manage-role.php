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

if (isset($_POST['simpan'])) {

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

if (isset($_GET['add-role-menu'])) {
  $id_role = $_GET['add-role-menu'];

  $roweditrolemenu = []; // Array untuk menampung data menu yang akan di edit.
  $editrolemenu = mysqli_query($config, "SELECT * FROM role_menus WHERE id_roles = '$id_role'");
  //$roweditrolemenu = mysqli_fetch_all($editrolemenu, MYSQLI_ASSOC);
  //contoh output: [0]1,[1]2,[2]3

  while ($editmenu = mysqli_fetch_assoc($editrolemenu)) {
    $roweditrolemenu[] = $editmenu['id_menu'];
  }


  //ini main menu(parent_id nya = 0)
  $menus = mysqli_query($config, "SELECT * FROM menus ORDER BY parent_id, urutan");

  $rowmenu = [];
  while ($m = mysqli_fetch_assoc($menus)) {
    $rowmenu[] = $m;
    //contoh output: []1,[]2,[]3
  }
}

if (isset($_POST['save'])) {
  $id_role = $_GET['add-role-menu'];
  $id_menus = $_POST['id_menus'] ?? []; //--> Versi Ternary
  // if ($_POST['id_menus']) {
  //   $id_menus = $_POST['id_menus'];
  // } else {
  //   $id_menus = [];
  // }

  mysqli_query($config, "DELETE FROM role_menus WHERE id_roles = '$id_role'"); // Hapus semua menu yang sudah ada.
  foreach ($id_menus as $m) {
    $id_menu = $m;
    mysqli_query($config, "INSERT INTO role_menus(id_roles, id_menu) VALUES ('$id_role','$id_menu')");
  }
  header("location:?page=manage-role&add-role-menu=" . $id_role . "&add=success"); //redirect ke halaman manage-role
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

        <?php if (isset($_GET['add-role-menu'])) : ?>
          <form action="" method="post">
            <div class="mb3">
              <ul>
                <?php foreach ($rowmenu as $mainmenu): ?>
                  <?php if ($mainmenu['parent_id'] == 0 or $mainmenu['parent_id'] == ''): ?>
                    <li>
                      <label for="">
                        <!-- jika value id_menu nilainya 1 == nilai dari tbl role_menus
                         jika nilai id_menu dari tbl role_menus juga == 1, maka kita check  -->
                        <input <?php echo in_array($mainmenu['id'], $roweditrolemenu) ? 'checked' : '' ?> type="checkbox"
                          name="id_menus[]" value="<?php echo $mainmenu['id'] ?>">
                        <?php echo $mainmenu['nm_menu'] ?>
                      </label>
                      <ul>
                        <?php foreach ($rowmenu as $submenu): ?>
                          <?php if ($submenu['parent_id'] == $mainmenu['id']): ?>
                            <li>
                              <label for="">
                                <input <?php echo in_array($submenu['id'], $roweditrolemenu) ? 'checked' : '' ?> type="checkbox"
                                  name="id_menus[]" value="<?php echo $submenu['id'] ?>">
                                <?php echo $submenu['nm_menu'] ?>
                              </label>
                            </li>
                          <?php endif ?>
                        <?php endforeach ?>
                      </ul>
                    </li>
                  <?php endif ?>
                <?php endforeach ?>
              </ul>
            </div>

            <div class="mb-3">
              <button class="btn btn-primary" type="submit" name="save">Save Change</button>
            </div>
          </form>

        <?php else: ?>
          <form action="" method="post">
            <div class="mb-3">
              <label for="">Role Name*</label>
              <input type="text" class="form-control" name="nm_role" placeholder="Enter Role" required
                value="<?= isset($_GET['edit']) ? $rowedit['nm_role'] : ''; ?>">
            </div>
            <div class="mb-3">
              <input type="submit" class="btn btn-success" name="simpan" value="Save">
            </div>
          </form>

        <?php endif ?>
      </div>
    </div>
  </div>
</div>