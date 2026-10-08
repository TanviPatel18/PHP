<?php

include "db.php";


$id = $_POST['id'];

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$birth_date = $_POST['birth_date'];
$phone = $_POST['phone'];
$location = $_POST['location'];
$hobby = $_POST['hobby'];
// $image=$_POST['image'];


/* Get old image */

$sql = "SELECT image FROM users WHERE id = $id";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

$old_image = $row['image'];

/* Delete image using × */

if (isset($_POST['delete_image']))
{
    if (!empty($old_image))
    {
        $old_image_path = "uploads/" . $old_image;

        if (file_exists($old_image_path))
        {
            unlink($old_image_path);
        }
    }

    $image_name = "";
}


/* Upload new image */

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0)
{
    $image = $_FILES['image'];

    $allowed_types = [
        'image/jpeg',
        'image/png'
    ];

    $image_info = getimagesize($image['tmp_name']);

    if ($image_info === false)
    {
        die("Please upload a valid image.");
    }

    if (!in_array($image_info['mime'], $allowed_types))
    {
        die("Only JPG, JPEG and PNG images are allowed.");
    }

    /* Get original image name */

    $new_image = $image['name'];

    $upload_folder = "uploads/";

    /* Upload new image */

    if (!move_uploaded_file(
        $image['tmp_name'],
        $upload_folder . $new_image
    ))
    {
        die("Failed to upload image.");
    }

    /* Delete old image */

    if (!empty($old_image) && $old_image != $new_image)
    {
        $old_image_path = $upload_folder . $old_image;

        if (file_exists($old_image_path))
        {
            unlink($old_image_path);
        }
    }

    $image_name = $new_image;
}


/* Keep old image */

if (
    !isset($_POST['delete_image']) &&
    (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0)
)
{
    $image_name = $old_image;
}

/* Update database */

$sql = "UPDATE users SET

        first_name = '$first_name',
        last_name = '$last_name',
        email = '$email',
        birth_date = '$birth_date',
        phone = '$phone',
        location = '$location',
        hobby = '$hobby',
        image = '$image_name'

        WHERE id = $id";


if (mysqli_query($conn, $sql))
{
    header("Location: user.php");
    exit();
}
else
{
    echo "Error: " . mysqli_error($conn);
}

?>