<?php

$host = "localhost";
$database_user = "root";
$database_name = "business_rating";
$password= "Admin@1234";

$conn = mysqli_connect($host, $database_user, $password, $database_name);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

?>