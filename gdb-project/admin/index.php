<?php
require "../controller/db-connection.php";
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$product_present;

if (isset($_POST['snoDelete'])) {
    $sno = $_POST['snoDelete'];

    $sql_select = "SELECT * FROM `product` WHERE `product_id` = '$sno'";
    $result_select = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_assoc($result_select);
    $product_image = $row['product_image'];
    $file_check = file_exists("../assets/imgs/" . $product_image);
    if ($file_check) {
        unlink("../assets/imgs/" . $product_image);
    }
    $sql = "DELETE FROM `product` WHERE `product_id` = '$sno'";
    $result = mysqli_query($conn, $sql);



    $cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
    $cart = json_decode($cart);

    $new_cart = array();
    foreach ($cart as $c) {
        if ($c->product_id != $sno) {
            array_push($new_cart, $c);
        }
    }

    setcookie("cart", json_encode($new_cart));


}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../assets/css/admin_style.css?v=<?php echo time(); ?>">
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="add_product.php">Add Product</a>
                </li>
            </ol>
        </nav>
    </div>
</nav>
<table class="table align-middle mb-0 bg-white">

    <thead>
        <tr>
            <th>
                Product Image</th>
            <th>Product Serail Number</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <?php
    $sql = "SELECT * FROM `product`";
    $result = mysqli_query($conn, $sql);
    $s_no = 10000;
    if (mysqli_num_rows($result) >= 1) {
        $product_present = true;
        while ($row = mysqli_fetch_assoc($result)) {
            echo " <tbody class='table_body'>

            <tr>
            <td>
                <div class='d-flex align-items-center'>
                    <img src='../assets/imgs/{$row["product_image"]}' alt='' class='index_image'/>
                    </div>
            </td>
            <td>
                <p class='fw-normal mb-1' style='font-size:1.5rem'>{$s_no}</p>
                
            </td>
            <td>
                <p class='badge badge-success  d-inline' style='font-size:1.5rem;' >{$row['product_name']}</p>
            </td>
            <td style='font-size:1.5rem'>\${$row['product_price']}</td>
            <td class='index_button'> 
             <a class='edit_button' href='edit_product.php?id=" . $row['product_id'] . "' id=" . $row['product_id'] . "><strong id='edit-btn'>Edit</strong></a> 
<a  data-toggle='modal' data-target='#delete-modal-" . $row['product_id'] . "'>
  <strong id='delete-btn'>Delete</strong>
</a>
</td>
<!-- Modal -->
<div class='modal fade' id='delete-modal-" . $row['product_id'] . "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='exampleModalLabel'>Modal title</h5>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
      <div class='modal-body'>
        Are you sure you want to delete ?
      </div>
      <div class='modal-footer'>
    
      <form action='index.php' method='post' class='w-50'>
    <input type='hidden' name='snoDelete' value=" . $row['product_id'] . ">
    <div class='d-flex m-2'> 
        <button type='submit' class='snoDelete btn btn-primary'>Delete Conform</button>
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
</div>
        </form>
      </div>
    </div>
  </div>
</div>
</td>
          </tr>";
            $s_no += 1;
        }

    } else {
        $product_present = false;
    }
    ;


    ?>

</table>
<hr>
<?php
if ($product_present == false) {
    echo "<div class='product_div'><h1>product is not present</h1></div> ";
}

?>

</div>
<!-- MDB -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>

</body>

</html>