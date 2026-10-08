<?php
    include "db.php";

    $first_name=$_POST['first_name'];
    $last_name=$_POST['last_name'];
    $email=$_POST['email'];
    $birth_date=$_POST['birth_date'];
    $phone=$_POST['phone'];
    $location=$_POST['location'];
    $hobby=$_POST['hobby'];
  
    $image=$_FILES['image'];
    $allowed_types=['image/jpeg','image/png'];

    /* Check if image was uploaded */
    if ($image['error'] !== 0) 
    {
        die("Error uploading image.");
    }
    $image_info = getimagesize($image['tmp_name']);

    if ($image_info === false) {
        die("Please upload a valid image.");
    }


    /* Check image type */
    if (!in_array($image_info['mime'], $allowed_types)) 
    {
        die("Only JPG, JPEG and PNG images are allowed.");
    }

    /* Get file extension */
    $image_name = $image['name'];


    /* Upload folder */
    $upload_folder = "uploads/";


    /* Move image to uploads folder */
    if (!move_uploaded_file($image['tmp_name'],
        $upload_folder . $image_name)) 
    {
        die("Failed to upload image.");
    }

    $sql="INSERT INTO users
          (first_name,last_name,email,birth_date,phone,location,hobby,image)
          VALUES
          ('$first_name','$last_name','$email','$birth_date','$phone','$location','$hobby','$image_name')";

    if(mysqli_query($conn,$sql))
    {
        header("Location: user.php");
        exit();
    }
    else{
        echo "Error:" .mysqli_error($conn);
    }
?>