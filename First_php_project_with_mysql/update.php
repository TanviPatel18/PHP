<?php

include "db.php";

$id = $_POST['id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$location = $_POST['location'];
$hobby = $_POST['hobby'];

$sql = "UPDATE users SET
        first_name = '$first_name',
        last_name = '$last_name',
        email = '$email',
        phone = '$phone',
        location = '$location',
        hobby = '$hobby'
        WHERE id = $id";

if (mysqli_query($conn, $sql)) {

    header("Location: user.php");
    exit();

} else {

    echo "Error: " . mysqli_error($conn);

}

?>