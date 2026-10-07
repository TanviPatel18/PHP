<?php

include "db.php";

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id = $id";

if (mysqli_query($conn, $sql)) {

    header("Location: user.php");
    exit();

} else {

    echo "Error: " . mysqli_error($conn);

}

?>