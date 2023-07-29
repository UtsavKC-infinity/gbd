<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../assets/css/customer_style.css?v=<?php echo time(); ?>">
</head>

<body>
  <nav class="main-nav">
    <ul class="nav-items">
      <a class="nav-item" href="customer_index.php">Home</a>
      <a class="nav-item" href="">About</a>
      <a class="nav-item" href="">Contact</a>
      <a class="nav-item" href="add_cart.php">Cart</a>
    </ul>
  </nav>
  <?php
  $cart = isset($_COOKIE["product_details"]) ? $_COOKIE["product_details"] : "[]";
  $cart = json_decode($cart);


  foreach ($cart as $c) {
    ?>
    <?php
    echo "   <container class='cart-container'>
            <div class='image-cart'>
                <img src='../assets/imgs/{$c->product_image}' alt='' srcset=''>
            </div>
            <div class='pname-cart'>
                <h3>Product Name:{$c->product_name}</h3>
            </div>
            <div class='pprice-cart'>
                <h3>Product Price:{$c->product_price}</h3>
            </div>
            <div class='p-quantity'>
              <div>
               <h3>Product Quantity:{$c->product_quantity}</h3>
               </div>
            </div>


            

            <div class='cart-actions'>
                <a href='delete_cart.php?id=" . $c->product_id . "'>Delete</a>
            </div>
          
        </container>";
  }

  if (empty($cart)) {
    echo " <div class='empty_cart'>
      <h2>Cart is empty. So please add some product.</h2>
    </div>
    ";
  } ?>
  <div id="footer-section">
    <button><a id="checkout" href="shiping_billing_address.php"> CheckOut</a></button>
</body>

</html>