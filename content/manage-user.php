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

$id_user = isset($_GET['manage-user-role']) ? $_GET['manage-user-role'] : '';

$queryrole = mysqli_query($config, "SELECT * FROM roles ORDER BY id DESC");
$rowroles = mysqli_fetch_all($queryrole, MYSQLI_ASSOC);

$queryuserrole = mysqli_query($config, "SELECT user_roles.*, roles.nm_role FROM user_roles
                                        LEFT JOIN roles ON user_roles.id_role = roles.id
                                        WHERE id_user = '$id_user'
                                        ORDER BY user_roles.id DESC");
$rowuserroles = mysqli_fetch_all($queryuserrole, MYSQLI_ASSOC);

if (isset($_POST['id_role'])) {
  $id_role = $_POST['id_role'];
  $queryinsert = mysqli_query($config, "INSERT INTO user_roles(id_role, id_user) VALUES ('$id_role','$id_user')");
  header("location:?page=manage-user&manage-user-role=" . $id_user . "&add-role=success");
}
?>

<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <?php if (isset($_GET['manage-user-role'])):
          $title = "Add User Role : ";
        elseif (isset($_GET['edit'])):
          $title = "Edit User : ";
        else:
          $title = "Add User : ";
        endif ?>
        <h5 class="card-title"><?php echo $title ?></h5>

        <?php if (isset($_GET['manage-user-role'])): ?>
          <div align="right" class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Role</button>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Role Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rowuserroles as $key => $rowuserrole): ?>
                <tr>
                  <td><?php echo $key += 1; ?></td>
                  <td><?php echo $rowuserrole['nm_role'] ?></td>
                  <td><a href="" class="btn btn-primary btn-sm">Edit</a>
                    <a href="" onclick="return confirm('Are You Sure...?')" class="btn btn-danger btn-sm">Delete</a>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        <?php else: ?>

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
        <?php endif ?>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class=" modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Role : </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="" class="form-label">Role Name</label>
            <select name="id_role" id="" class="form-control">
              <option value="">Select One</option>
              <?php foreach ($rowroles as $rowrole): ?>
                <option value="<?php echo $rowrole['id'] ?>"><?php echo $rowrole['nm_role'] ?></option>
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