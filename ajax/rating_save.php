<?php

include '../db.php';

$business_id = $_POST['business_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$rating = $_POST['rating'];

$check = mysqli_query($conn,
"SELECT id FROM ratings
WHERE business_id='$business_id'
AND (email='$email' OR phone='$phone')");

if(mysqli_num_rows($check) > 0) {

    $row = mysqli_fetch_assoc($check);

    mysqli_query($conn,
    "UPDATE ratings
    SET
    name='$name',
    email='$email',
    phone='$phone',
    rating='$rating'
    WHERE id='".$row['id'].'"');

} else {

    mysqli_query($conn,
    "INSERT INTO ratings(business_id,name,email,phone,rating)
    VALUES('$business_id','$name','$email','$phone','$rating')");
}

$avgQuery = mysqli_query($conn,
"SELECT ROUND(AVG(rating),1) as avg_rating
FROM ratings
WHERE business_id='$business_id'");

$avg = mysqli_fetch_assoc($avgQuery);

header('Content-Type: application/json');

echo json_encode([
    'status' => true,
    'avg_rating' => $avg['avg_rating']
]);

?>