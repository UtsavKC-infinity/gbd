<?php

require "../controller/db-connection.php";

$p_id = $_GET['id'];

$sql = "SELECT * FROM `product` WHERE `product_id` = '$p_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$product_name = $row['product_name'];
$product_image = $row['product_image'];
$product_price = $row['product_price'];
$product_id = $row['product_id'];
$cart = isset($_COOKIE["product_details"]) ? $_COOKIE["product_details"] : "[]";
$cart = json_decode($cart);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="../assets/css/customer_style.css?v=<?php echo time(); ?>" />
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
  <container>
    <form class="product_grid" action=' product_view.php?id=<?php $product_id ?>' method='post'>
      <input type="hidden" name="product_id" id="product_id" value=<?php echo $product_id ?>>
      <input type="hidden" id="product_image" value=<?php echo $product_image ?>>
      <?php
      echo "<div class='product_image'><img value=" . $product_image . " src=../assets/imgs/" . $product_image . " alt='' srcset='' style='height:85.6vh;' /></div>";
      ?>

      <div class="product_contain">
        <p>
          Product Name :
          <strong id="product_name">
            <?php echo $product_name; ?>
          </strong>
        </p>
        <p>Product Price :
          <strong id="product_price">
            <?php echo "\$$product_price"; ?>
          </strong>
        </p>
        <div class="counter">

          <div><button id="add" style="background-color:green;">Add Product</button></div>
          <div><button><span id="dis">0</span></button></div>
          <input type="hidden" name="product_quantity" id="product_quantity" value>
          <div><button id="min" style="background-color:red;">Minus Product</button></div>

        </div>
        <div class="product_button">
          <a href="shiping_billing_address.php?id=<?php echo $product_id ?>">Purchase</a>
          <a id="add_cart" href="#">Add To Cart</a>
        </div>

      </div>
    </form>
  </container>
  <script>
    const product_name = document.getElementById("product_name").innerText;

    const product_price = document.getElementById("product_price").innerText;

    const product_image = document.getElementById("product_image").value;

    const product_id = document.getElementById("product_id").value;

    const addCart = document.getElementById("add_cart");
    const addProduct = document.getElementById("add");
    const deleteProduct = document.getElementById("min");
    const dis = document.getElementById("dis");


    let count = 0;

    addProduct.addEventListener("click", (e) => {
      e.preventDefault();
      count += 1
      dis.innerText = count;

    });
    deleteProduct.addEventListener("click", (e) => {
      e.preventDefault()
      if (count != 0) {
        count -= 1;
        dis.innerText = count;
      }

    })


    addCart.addEventListener("click", () => {
      if (dis.innerText == 0) {
        alert("Product Quantity must not be zero");
        return;

      }

      const cookieValues = document.cookie.split("=");
      let cookieProducts;
      cookieValues.forEach((el, idx) => {
        if (el === 'product_details') {
          cookieProducts = cookieValues[idx + 1];
          console.log(cookieProducts);
        }
      });
      if (!cookieProducts) {


        cookieProducts = [{
          "product_id": product_id,
          "product_name": product_name,
          "product_image": product_image,
          "product_price": product_price,
          "product_quantity": dis.innerText
        }]
        document.cookie = `product_details=${JSON.stringify(cookieProducts)}`;
        alert("Product Added To The Cart");


      } else {
        cookieProducts = JSON.parse(cookieProducts);
        const productInCookie = cookieProducts.find(el => el.product_id === product_id);
        if (!productInCookie) {
          cookieProducts.push({
            "product_id": product_id,
            "product_name": product_name,
            "product_image": product_image,
            "product_price": product_price,
            "product_quantity": dis.innerText
          });
        } else {
          cookieProducts = cookieProducts.map(el => el.product_id === product_id ? ({
            ...el,
            product_quantity: count
          }) : el);

        }
        document.cookie = `product_details=${JSON.stringify(cookieProducts)}`;
        alert("Product Added To The Cart");
      }

    });

  </script>
</body>

</html>