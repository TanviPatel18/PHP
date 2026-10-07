<?php
    include "db.php";

    $first_name=$_POST['first_name'];
    $last_name=$_POST['last_name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $location=$_POST['location'];
    $hobby=$_POST['hobby'];


    $sql="INSERT INTO users
          (first_name,last_name,email,phone,location,hobby)
          VALUES
          ('$first_name','$last_name','$email','$phone','$location','$hobby')";

    if(mysqli_query($conn,$sql))
    {
        header("Location: user.php");
        exit();

    }
    else{
        echo "Error:" .mysqli_error($conn);
    }
?>