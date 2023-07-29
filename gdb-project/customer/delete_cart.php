<?php

echo '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <input type="hidden"  id="p_id" value="' . $_GET["id"] . '">
    
</body>

<script>
    const pID = document.getElementById("p_id").value;
    console.log(pID);
    const product_cookie = document.cookie.split("=");
    let p_details;
    product_cookie.forEach((el, idx) => {
        if (el === "product_details") {
            p_details = product_cookie[idx + 1];
        }
    })
    p_details = JSON.parse(p_details);
    p_details = p_details.filter(el => String(el.product_id) !== pID);
    document.cookie = `product_details=${JSON.stringify(p_details)}`;
    document.location = `add_cart.php`;
</script>
</html>
';

?>