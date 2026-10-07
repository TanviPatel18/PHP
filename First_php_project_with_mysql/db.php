<?php
    $conn= mysqli_connect("localhost","root","","crud_db");
    if(!$conn)
    {
        die("Detabase Connection failed:".mysqli_connect_error());  
    }
?>