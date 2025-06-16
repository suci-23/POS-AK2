<?php

$id_major = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM majors WHERE id='$id_major'");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];

  $querymodulsdetails = mysqli_query($config, "SELECT file FROM moduls_details WHERE id_modul = '$id'");
  $rowmodulsdetails = mysqli_fetch_assoc($querymodulsdetails);
  unlink('uploads/' . $rowmodulsdetails['file']);

  //DELETE
  $querydelete = mysqli_query($config, "DELETE FROM moduls_details WHERE id_modul = '$id'");
  $querydelete = mysqli_query($config, "DELETE FROM moduls WHERE id = '$id'");

  if ($querydelete) {
    header("location:?page=moduls&delete=success");
  } else {
    header("location:?page=moduls&delete=failed");
  }
}

if (isset($_POST['save'])) {

  // Ada ga parameter bernama Edit? YES, jalankan perintah EDIT / UPDATE.
  // NO, tambah data baru / INSERT.

  $id_instructor = $_POST['id_instructor'];
  $id_major = $_POST['id_major'];
  $nm_modul = $_POST['nm_modul'];

  $queryinsert = mysqli_query($config, "INSERT INTO moduls(id_instructor, id_major, nm_modul) VALUES ('$id_instructor', '$id_major', '$nm_modul')");

  if ($queryinsert) {
    $id_modul = mysqli_insert_id($config); // Ambil ID terakhir yang telah di-insert.

    //$_FILES
    foreach ($_FILES['file']['name'] as $index => $file) {
      if ($_FILES['file']['error'][$index] == 0) {
        $nm_file = basename($_FILES['file']['name'][$index]);
        $filename = uniqid() . '-' . $nm_file;
        $path = 'uploads/';
        $targetpath = $path . $filename; // Path untuk menyimpan file.

        if (move_uploaded_file($_FILES['file']['tmp_name'][$index], $targetpath)) {
          $insertmoduldetail = mysqli_query($config, "INSERT INTO moduls_details (id_modul, file) VALUES ('$id_modul', '$filename')"); // Insert detail file ke database.
        }
      }
    }
    header("location:?page=moduls&add=sucess");
  }
}

$id_instructor = isset($_SESSION['ID_USER']) ? $_SESSION['ID_USER'] : '';
$queryinstructormajor = mysqli_query($config, "SELECT majors.nm_major, instructor_majors.*
                                    FROM instructor_majors LEFT JOIN majors ON majors.id = instructor_majors.id_major
                                    WHERE instructor_majors.id_instructor = '$id_instructor'");

$rowinstructormajors = mysqli_fetch_all($queryinstructormajor, MYSQLI_ASSOC);

$id_modul = isset($_GET['detail']) ? $_GET['detail'] : '';
$querymodul = mysqli_query($config, "SELECT majors.nm_major, instructors.nm_instructor, moduls.* FROM moduls
                      LEFT JOIN majors ON majors.id = moduls.id_major
                      LEFT JOIN instructors ON instructors.id = moduls.id_instructor WHERE moduls.id = '$id_modul'");
$rowmodul = mysqli_fetch_assoc($querymodul);

//QUERY ke Table Detail Modul
$querydetailmodul = mysqli_query($config, "SELECT * FROM moduls_details WHERE id_modul = '$id_modul'");
$rowdetailmodul = mysqli_fetch_all($querydetailmodul, MYSQLI_ASSOC);

if (isset($_GET['download'])) {
  $file = $_GET['download'];
  $filepath = 'uploads/' . $file;

  if (file_exists($filepath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($filepath) . '');
    header('Ecpires:0');
    header('Cache-Control:-must-revalidate');
    header('Pragma:public');
    header('Content-Length:' . filesize($filepath) . '');
    ob_clean();
    flush();
    readfile($filepath);
    exit;
  }
}
?>

<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          <!-- Ganti judul di bagian Card Title -->
          <?= isset($_GET['detail']) ? 'Detail Modul' : 'Add Modul' ?>
        </h5>

        <?php if (isset($_GET['detail'])): ?>
          <!-- DETAIL MODUL -->
          <table class="table table-stripped">
            <tr>
              <th>Modul Name</th>
              <th>:</th>
              <td><?php echo $rowmodul['nm_modul'] ?></td>
              <th>Major</th>
              <th>:</th>
              <td><?php echo $rowmodul['nm_major'] ?></td>
            </tr>
            <tr>
              <th>Instructor</th>
              <th>:</th>
              <td><?php echo $rowmodul['nm_instructor'] ?></td>
            </tr>
          </table>

          <br><br>

          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>File Name</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rowdetailmodul as $index => $rowdml): ?>
                <tr>
                  <td><?php echo $index += 1; ?></td>
                  <td>
                    <a target="_blank" href="?page=manage-modul&download=<?php echo urlencode($rowdml['file']) ?>">
                      <?php echo $rowdml['file'] ?> <i class="bi bi-download"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>

        <?php else: ?>
          <!-- FORM TAMBAH MODUL -->
          <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-sm-6">
                <div class="mb-3">
                  <label for="" class="form-label">Instructor Name*</label>
                  <input readonly value="<?php echo $_SESSION['NAME'] ?>" type="text" class="form-control">
                  <input type="hidden" name="id_instructor" value="<?php echo $_SESSION['ID_USER'] ?>">
                </div>
                <div class="mb-3">
                  <label for="" class="form-label">Modul Name*</label>
                  <input value="" type="text" class="form-control" name="nm_modul" placeholder="Enter Modul Name"
                    required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="mb-3">
                  <label for="" class="form-label">Major Name*</label>
                  <select name="id_major" id="" class="form-control" required>
                    <option value="">Select One</option>
                    <?php foreach ($rowinstructormajors as $row): ?>
                      <option value="<?php echo $row['id_major'] ?>"><?php echo $row['nm_major'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <div align="right" class="mb-3">
                <button type="button" class="btn btn-primary addrow" id="addrow">+ Row</button>
              </div>

              <table class="table" id="myTable">
                <thead>
                  <tr>
                    <th>File</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>

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

<script>
  //var(ketika nilai kosong, ga error), let(wajib punya nilai), const(nilai ga boleh berubah)

  // const button = document.getElementById('addrow');
  // const button = document.getElementsByClassName('addrow');
  const button = document.querySelector('.addrow');
  const tbody = document.querySelector('#myTable tbody');

  button.addEventListener("click", function() {
    // alert('LooooLLL');
    const tr = document.createElement('tr'); //output: <tr></tr>
    tr.innerHTML = `
    <td><input type= 'file' name= 'file[]'></td>
    <td>Delete</td>
    `;

    tbody.appendChild(tr);
  });
</script>