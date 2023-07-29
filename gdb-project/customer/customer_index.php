<?php
require "../controller/db-connection.php";
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
$result = "";


if ($_SERVER['REQUEST_METHOD'] = 'POST') {
  $sql = 'SELECT * FROM product';
  $result = mysqli_query($conn, $sql);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../assets/css/customer_style.css?v=<?php echo time(); ?>">
</head>

<body>
  <nav class="main-nav">
    <ul class="nav-items">
      <a class="nav-item" href="">Home</a>
      <a class="nav-item" href="">About</a>
      <a class="nav-item" href="">Contact</a>
      <a class="nav-item" href="add_cart.php">Cart</a>
    </ul>
  </nav>
  <container class="main-container">
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
      echo "
<div class='product-container' name='product_image'><a href='product_view.php?id=" . $row['product_id'] . "'><img class='product_img' src=../assets/imgs/" . $row['product_image'] . " alt='' style='height:50vh;width:100%;border-radius:1rem; object-fit:cover;' /></a><hr><p style='width:fit-contain;font-size:1.5rem;text-align:center;background: radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%);'>{$row['product_name']}</p>
</div>
    ";
    }
    ?>
  </container>
</body>

</html>