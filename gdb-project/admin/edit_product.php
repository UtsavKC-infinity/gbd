<?php
require "../controller/db-connection.php";
$row = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM `product` WHERE `product_id` = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['product_Edit'])) {
        $id = $_POST['product_Edit'];
        $product_name = $_POST['product_name'];
        $product_image = $row['product_image'];
        $product_price = $_POST['product_price'];
        $product_name_check = $product_name != "" && is_numeric($product_name[0]) == false;
        $product_image_check = $product_image != "";
        $product_price_check = $product_price != "" && is_numeric($product_price);
        if ($product_image_check && $product_price_check && $product_name_check) {
            $sql = "UPDATE `product` SET `product_name` = '$product_name' , `product_image` = '$product_image', `product_price` = '$product_price' WHERE `product_id` = '$id'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                header("Location: index.php");
            } else {
                echo mysqli_error($conn);
            }
        } else {
            echo "fild missing";
        }
    }
}





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/admin_style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="add_product.php" target="_blank">Add Product</a>
                    </li>
                </ol>
            </nav>
        </div>
    </nav>
    <form action="edit_product.php?id=<?php echo $row['product_id'] ?>" method="POST" class="insert-form">
        <div class="form-group">
            <input type="hidden" name="product_Edit" value=<?php echo $row['product_id'] ?>>
            <label for="product_name">
                Product name
            </label>
            <input type="text" class="form-control" id="product_name" name="product_name" aria-describedby="emailHelp"
                value="<?php echo $row['product_name'] ?>" placeholder="Enter product name">
        </div>
        <div class="form-group">
            <label for="product_image">
                <?php echo $row['product_image'] ?>
            </label>
            <input type="file" class="form-control-file" id="product_image" name="product_image" value=<?php echo $row['product_image'] ?>>
        </div>
        <div class="form-group">
            <label for="product_price">Product Price</label>
            <input type="text" class="form-control" id="product_price" name="product_price"
                placeholder="Enter product price" value="<?php echo $row['product_price'] ?>">
        </div>
        </div>
        <button type="submit" class="btn btn-primary insert-btn">Submit</button>
    </form>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>

</html>