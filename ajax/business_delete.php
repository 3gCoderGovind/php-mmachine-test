<?php

include '../db.php';

$id = $_POST['id'];

mysqli_query($conn, "DELETE FROM businesses WHERE id='$id'");

header('Content-Type: application/json');

echo json_encode([
    'status' => true
]);

?>