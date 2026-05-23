<?php

include '../db.php';

$id = $_POST['id'];
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];

if(empty($id)) {

    $query = "INSERT INTO businesses(name,address,phone,email)
              VALUES('$name','$address','$phone','$email')";

    mysqli_query($conn, $query);

    $id = mysqli_insert_id($conn);

} else {

    $query = "UPDATE businesses
              SET
              name='$name',
              address='$address',
              phone='$phone',
              email='$email'
              WHERE id='$id'";

    mysqli_query($conn, $query);
}

$get = mysqli_query($conn,
"SELECT b.*, ROUND(AVG(r.rating),1) as avg_rating
FROM businesses b
LEFT JOIN ratings r ON b.id = r.business_id
WHERE b.id='$id'
GROUP BY b.id");

$data = mysqli_fetch_assoc($get);

$data['avg_rating'] = $data['avg_rating'] ? $data['avg_rating'] : 0;

$response = [
    'status' => true,
    'data' => $data
];

header('Content-Type: application/json');
echo json_encode($response);

?>