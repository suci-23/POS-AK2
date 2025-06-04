<?php

$id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM users WHERE id='$id_user'");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_GET['delete'])) {
  $id_user = $_GET['delete'];

  //QUERY SOFT DELETE
  $querydelete = mysqli_query($config, "UPDATE users SET deleted_at = 1 WHERE id = '$id_user'");

  if ($querydelete) {
    header("location:?page=users&delete=success");
  } else {
    header("location:?page=users&delete=failed");
  }
}

if (isset($_POST['nm_user'])) {

  // Ada ga parameter bernama Edit? YES, jalankan perintah EDIT / UPDATE.
  // NO, tambah data baru / INSERT.

  $nm_user = $_POST['nm_user'];
  $email = $_POST['email'];
  $password = isset($_POST['password']) ? sha1($_POST['password']) : $rowedit('password'); //supaya setelah edit tetep bisa munculin password lama tanpa isi password ulang

  // if ($password) {
  //   $password = $_POST['password'];
  // } else {
  //   $password = $rowedit['password'];
  // }

  if (!isset($_GET['edit'])) {
    $queryinsert = mysqli_query($config, "INSERT INTO users(nm_user, email, password) VALUES ('$nm_user','$email','$password')");
    header("location:?page=users&add=success");
  } else {
    $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
    $update = mysqli_query($config, "UPDATE users SET nm_user = '$nm_user', email = '$email', password = '$password' WHERE id = $id_user");
    header("location:?page=users&edit=success");
  }
}
?>

<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          <!-- Ganti judul di bagian Card Title -->
          <?= isset($_GET['edit']) ? 'Edit User' : 'Add User' ?>
        </h5>

        <form action="" method="post">
          <div class="mb-3">
            <label for="">Full Name*</label>
            <input type="text" class="form-control" name="nm_user" placeholder="Enter Your Name" required
              value="<?= isset($_GET['edit']) ? $rowedit['nm_user'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="">Email*</label>
            <input type="email" class="form-control" name="email" placeholder="Enter Your Email" required
              value="<?= isset($_GET['edit']) ? $rowedit['email'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="">Password*</label>
            <input type="password" class="form-control" name="password" placeholder="Enter Your Password"
              <?php echo empty($id_user) ? 'required' : '' ?>>
            <small>*Fill this area if you want to change your password</small>
          </div>
          <div class="mb-3">
            <input type="submit" class="btn btn-success" name="save" value="Save">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>