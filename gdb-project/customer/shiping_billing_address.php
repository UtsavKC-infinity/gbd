<?php
require "../controller/db-connection.php";
$check_empty = false;
$cart = isset($_COOKIE["product_details"]) ? $_COOKIE["product_details"] : "[]";
$cart = json_decode($cart);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $cart = isset($_COOKIE["product_details"]) ? $_COOKIE["product_details"] : "[]";
    $cart = json_decode($cart);
    foreach ($cart as $c) {

        $product_id = $c->product_id;
        $billing_address = $_POST["billing_address"];
        $shipping_address = $_POST["shipping_address"];

        if ($billing_address !== "" and $shipping_address !== "") {
            $query5 = "SELECT * FROM  `product` WHERE `product_id` = '$product_id' ";
            $result2 = mysqli_query($conn, $query5);
            $row2 = mysqli_fetch_assoc($result2);
            $price = $c->product_price;
            $product_quantity = $c->product_quantity;
            $sql = "SELECT MAX(order_id) FROM `final_order`";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $maxOrderId = $row['MAX(order_id)'] + 1;
            $insertSql = "INSERT INTO `final_order`(`order_id`, `shipping_id`, `billing_id`) VALUES('$maxOrderId', NULL, NULL)";
            mysqli_query($conn, $insertSql);
            $query4 = "INSERT INTO `order_product`(`order_id`,`product_id`,`product_quantity`,`product_price`) VALUES ('$maxOrderId','$product_id','$product_quantity','$price')";
            mysqli_query($conn, $query4);
            $query2 = "INSERT INTO `billing`(`billing_address`,`order_id`) VALUES ('$billing_address', '$maxOrderId')";
            mysqli_query($conn, $query2);
            $query3 = "INSERT INTO `shipping`(`shipping_address`,`order_id`) VALUES ('$shipping_address', '$maxOrderId')";
            mysqli_query($conn, $query3);
            $query5 = "SELECT * FROM `shipping` WHERE `order_id` ='$maxOrderId'";
            $result3 = mysqli_query($conn, $query5);
            $shipping_id = mysqli_fetch_assoc($result3)["shipping_id"];
            $query6 = "SELECT * FROM `billing` WHERE `order_id` = '$maxOrderId'";
            $result4 = mysqli_query($conn, $query6);
            $billing_id = mysqli_fetch_assoc($result4)["billing_id"];
            $insertfinalOrder = "UPDATE `final_order` SET `billing_id` = '$billing_id', `shipping_id` = '$shipping_id' WHERE `order_id` = '$maxOrderId';";
            mysqli_query($conn, $insertfinalOrder);

        } else {
            $check_empty = true;
        }

    }


} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $product_id = $_GET['id'];
    $billing_address = $_POST["billing_address"];
    $shipping_address = $_POST["shipping_address"];

    if ($billing_address !== "" and $shipping_address !== "") {
        $product_id = $_POST["id"];
        $query5 = "SELECT * FROM  `product` WHERE `product_id` = '$product_id' ";
        $result2 = mysqli_query($conn, $query5);
        $row2 = mysqli_fetch_assoc($result2);
        $price = $row2['product_price'];
        $sql = "SELECT MAX(order_id) FROM `final_order`";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $maxOrderId = $row['MAX(order_id)'] + 1;
        $insertSql = "INSERT INTO `final_order`(`order_id`, `shipping_id`, `billing_id`) VALUES('$maxOrderId', NULL, NULL)";
        mysqli_query($conn, $insertSql);
        $query4 = "INSERT INTO `order_product`(`order_id`,`product_id`,`product_quantity`,`product_price`) VALUES ('$maxOrderId','$product_id','$price')";
        mysqli_query($conn, $query4);
        $query2 = "INSERT INTO `billing`(`billing_address`,`order_id`) VALUES ('$billing_address', '$maxOrderId')";
        mysqli_query($conn, $query2);
        $query3 = "INSERT INTO `shipping`(`shipping_address`,`order_id`) VALUES ('$shipping_address', '$maxOrderId')";
        mysqli_query($conn, $query3);
        $query5 = "SELECT * FROM `shipping` WHERE `order_id` ='$maxOrderId'";
        $result3 = mysqli_query($conn, $query5);
        $shipping_id = mysqli_fetch_assoc($result3)["shipping_id"];
        $query6 = "SELECT * FROM `billing` WHERE `order_id` = '$maxOrderId'";
        $result4 = mysqli_query($conn, $query6);
        $billing_id = mysqli_fetch_assoc($result4)["billing_id"];
        $insertfinalOrder = "UPDATE `final_order` SET `billing_id` = '$billing_id', `shipping_id` = '$shipping_id' WHERE `order_id` = '$maxOrderId';";
        mysqli_query($conn, $insertfinalOrder);

    } else {
        $check_empty = true;
    }

}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        if ($check_empty === true) {
            echo "<h1> You should add the billing and shipping addresss</h1>";
        } else {
            echo "<h1> You successfully add you billing and shipping address</h1>";
            echo "Billing Address : {$billing_address} <br> Shipping Address : {$shipping_address}";

        }
    }


    ?>
    <section class="address-form">
        <form action="#" method="post">
            <div class="main-form">
                <input type="hidden" name="id" value="<?php echo $product_id ?>">
                <label for="billing_address" id="b_address"> Billing Address: </label>
                <input type="text" id="b_address" class="billing_address" name="billing_address" /><br />
                <label for="shipping_address" id="s_address">Shipping Address:</label>
                <input type="text" id="s_address" class="shipping_address" name="shipping_address" /><br />
                <button type="submit">Submit</button>
            </div>
            <?php


            ?>
        </form>

    </section>
</body>

</html>