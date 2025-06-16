<?php
$queryshow = mysqli_query($config, "SELECT products.*,categories.nm_category FROM products 
                                    LEFT JOIN categories ON categories.id = products.id_category
                                    ORDER BY products.id DESC");
$rows = mysqli_fetch_all($queryshow, MYSQLI_ASSOC);
// print_r($rows);
?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-tittle mt-3">Data Products</h5>
        <div class="mb-3" align="right">
          <a href="?page=manage-instructor" class="btn btn-primary">Add Product</a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered datatable">
            <thead>
              <tr>
                <th>No</th>
                <th>Category</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Desc</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $key => $data): ?>
              <tr>
                <td><?php echo $key += 1; ?></td>
                <td><?php echo $data['nm_category'] ?></td>
                <td><?php echo $data['nm_product'] ?></td>
                <td><?php echo $data['price'] ?></td>
                <td><?php echo $data['qty'] ?></td>
                <td><?php echo $data['description'] ?></td>
                <td>
                  <a href="?page=add-instructor-major&id=<?php echo $data['id'] ?>" class="btn btn-warning">Add
                    Major</a>
                  <a href="?page=manage-instructor&edit=<?php echo $data['id'] ?>" class="btn btn-primary">Edit</a>
                  <a onclick="return confirm('Are You Sure...?')"
                    href="?page=manage-instructor&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
                </td>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>