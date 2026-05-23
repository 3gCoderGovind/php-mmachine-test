<?php

include '../db.php';

$id = $_GET['id'];

$query = mysqli_query($conn,
"SELECT * FROM businesses WHERE id='$id'");

$data = mysqli_fetch_assoc($query);

header('Content-Type: application/json');

echo json_encode($data);

?>