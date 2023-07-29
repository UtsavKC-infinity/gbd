<?php
require "../controller/db-connection.php";
$target_dir = '../assets/imgs/';
$target_file = "";
$imageFileType = "";
$product_image = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    $image_name = basename($_FILES['fileToUpload']['name']);
    $image_name = implode(explode(" ", $image_name));
    $target_file = $target_dir . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
    } else {
        echo "File is not an image.";

    }
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

    }
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";

    }

    $image = imagecreatefromjpeg($_FILES['fileToUpload']['tmp_name']);
    imagejpeg($image, $target_file, 40);
    $product_image = $image_name;




    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_name_check = $product_name != "" && is_numeric($product_name[0]) == false;
    $product_price_check = $product_price != "" && is_numeric($product_price);
    if ($product_price_check && $product_name_check) {
        $sql = "INSERT INTO `product` ( `product_name`, `product_image`, `product_price`) VALUES ('$product_name', '$product_image','$product_price')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            header("location: index.php");
        } else {
            echo mysqli_error($conn);
        }
    } else {
        echo "you should fill up the form correctly";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/admin_style.css?v=<?php echo time(); ?>">
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
                        <a href="#">Add Product</a>
                    </li>
                </ol>
            </nav>
        </div>
    </nav>
    <form action=" add_product.php" method="post" class="insert-form" enctype="multipart/form-data">
        <div class="form-group">
            <label for="product_name">
                Product name
            </label>
            <input type="text" class="form-control" id="product_name" name="product_name" aria-describedby="emailHelp"
                placeholder="Enter product name">
        </div>
        <div>
            <p>Select image to upload:</p>
            <input type="file" name="fileToUpload" id="fileToUpload">
        </div>
        <div class="form-group">
            <label for="product_price">Product Price</label>
            <input type="text" class="form-control" id="product_price" name="product_price"
                placeholder="Enter product price">
        </div>
        </div>
        <button type="submit" class="btn btn-primary insert-btn">Submit</button>
    </form>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>

</html>