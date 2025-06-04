<?php

$id_instructor = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM instructors WHERE id='$id_instructor'");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_GET['delete'])) {
  $id_instructor = $_GET['delete'];

  //DELETE
  $querydelete = mysqli_query($config, "DELETE FROM instructors WHERE id = '$id_instructor'");

  if ($querydelete) {
    header("location:?page=instructors&delete=success");
  } else {
    header("location:?page=instructors&delete=failed");
  }
}

if (isset($_POST['nm_instructor'])) {

  // Ada ga parameter bernama Edit? YES, jalankan perintah EDIT / UPDATE.
  // NO, tambah data baru / INSERT.

  $nm_instructor = $_POST['nm_instructor'];
  $gender = $_POST['gender'];
  $education = $_POST['education'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $address = $_POST['address'];



  if (!isset($_GET['edit'])) {
    $queryinsert = mysqli_query($config, "INSERT INTO instructors(nm_instructor, gender, education, phone, email, address) VALUES ('$nm_instructor', '$gender', '$education', '$phone', '$email', '$address')");
    header("location:?page=instructors&add=success");
  } else {
    $id_instructor = isset($_GET['edit']) ? $_GET['edit'] : '';

    $update = mysqli_query($config, "UPDATE instructors SET nm_instructor = '$nm_instructor', gender = '$gender', education = '$education', phone = '$phone', email = '$email', address = '$address' WHERE id = $id_instructor");
    // print_r($_POST);
    // die;
    header("location:?page=instructors&edit=success");
  }
}
?>

<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          <!-- Ganti judul di bagian Card Title -->
          <?= isset($_GET['edit']) ? 'Edit Instructor' : 'Add Instructor' ?>
        </h5>

        <form action="" method="post">
          <div class="mb-3">
            <label for="">Instructor Name*</label>
            <input type="text" class="form-control" name="nm_instructor" placeholder="Instructor Name" required
              value="<?= isset($_GET['edit']) ? $rowedit['nm_instructor'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="">Gender*</label>
            <p>
              <input type="radio" name="gender" value="1"
                <?php echo isset($rowedit['gender']) ? ($rowedit['gender'] == 1) ? 'checked' : '' : ''; ?>> Male
              <input type="radio" name="gender" value="0"
                <?php echo isset($rowedit['gender']) ? ($rowedit['gender'] == 0) ? 'checked' : '' : ''; ?>> Female
            </p>
          </div>
          <div class="mb-3">
            <label for="">Education*</label>
            <input type="text" class="form-control" name="education" placeholder="Instructor Education" required
              value="<?= isset($_GET['edit']) ? $rowedit['education'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="">Email*</label>
            <input type="email" class="form-control" name="email" placeholder="Instructor Email" required
              value="<?= isset($_GET['edit']) ? $rowedit['email'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="">Phone</label>
            <input type="number" class="form-control" name="phone" placeholder="Instructor Phone"
              value="<?= isset($_GET['edit']) ? $rowedit['phone'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="">Address</label>
            <input type="text" class="form-control" name="address" placeholder="Instructor Address"
              value="<?= isset($_GET['edit']) ? $rowedit['address'] : ''; ?>">
          </div>
          <div class="mb-3">
            <input type="submit" class="btn btn-success" name="save" value="Save">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>