<?php

$server_name = 'localhost';
$username = 'root';
$password = "";
$database_name = 'ecommerce_database';


$conn = mysqli_connect($server_name, $username, $password, $database_name);

if ($conn) {
    // echo "you are successfully connected with the database";
} else {
    echo mysqli_connect_error();


}
?>