<?php

$id_product = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryedit = mysqli_query($config, "SELECT * FROM products WHERE id='$id_product'");
$rowedit = mysqli_fetch_assoc($queryedit);

if (isset($_GET['delete'])) {
  $id_product = $_GET['delete'];

  //DELETE
  $querydelete = mysqli_query($config, "DELETE FROM products WHERE id = '$id_product'");

  if ($querydelete) {
    header("location:?page=products&delete=success");
  } else {
    header("location:?page=products&delete=failed");
  }
}

if (isset($_POST['nm_product'])) {

  // Ada ga parameter bernama Edit? YES, jalankan perintah EDIT / UPDATE.
  // NO, tambah data baru / INSERT.

  $nm_product = $_POST['nm_product'];
  $id_category = $_POST['id_category'];
  $price = $_POST['price'];
  $qty = $_POST['qty'];
  $description = $_POST['description'];



  if (!isset($_GET['edit'])) {
    $queryinsert = mysqli_query($config, "INSERT INTO products(id_category, nm_product, price, qty, description) VALUES ('$id_category', '$nm_product', '$price', '$qty', '$description')");
    header("location:?page=products&add=success");
  } else {
    $id_product = isset($_GET['edit']) ? $_GET['edit'] : '';

    $update = mysqli_query($config, "UPDATE products SET id_category = '$id_category', nm_product = '$nm_product', price = '$price', qty = '$qty', description = '$description' WHERE id = $id_product");
    // print_r($_POST);
    // die;
    header("location:?page=products&edit=success");
  }
}

$querycategoryproduct = mysqli_query($config, "SELECT * FROM categories ORDER BY id DESC");
$rowcategoryproduct = mysqli_fetch_all($querycategoryproduct, MYSQLI_ASSOC);
?>

<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          <!-- Ganti judul di bagian Card Title -->
          <?= isset($_GET['edit']) ? 'Edit product' : 'Add product' ?>
        </h5>

        <form action="" method="post">
          <div class="mb-3">
            <label for="">Category Product*</label>
            <select name="id_category" id="" class="form-control">
              <option value="">Select One</option>
              <?php foreach ($rowcategoryproduct as $rowcategory): ?>
                <option
                  <?php echo isset($rowedit) ? ($rowcategory['id'] == $rowedit['id_category']) ? 'selected' : '' : '' ?>
                  value="<?php echo $rowcategory['id'] ?>"><?php echo $rowcategory['nm_category'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="">Product Name*</label>
            <input type="text" class="form-control" name="nm_product" placeholder="Enter Product Name" required
              value="<?= isset($_GET['edit']) ? $rowedit['nm_product'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="">Price*</label>
            <input type="number" class="form-control" name="price" placeholder="Enter Price of Product" required
              value="<?= isset($_GET['edit']) ? $rowedit['price'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="">Qty*</label>
            <input type="number" class="form-control" name="qty" placeholder="Enter Qty Product" required
              value="<?= isset($_GET['edit']) ? $rowedit['qty'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="">Description</label>
            <textarea name="description" id=""
              class="form-control"><?php echo isset($rowedit['edit']) ? $rowedit['description'] : '' ?></textarea>
          </div>
          <div class="mb-3">
            <input type="submit" class="btn btn-success" name="save" value="Save">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>