<?php 

    include "db.php";

    $sql="select * FROM  users";
    $result=mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Users</title>
    

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>Users List</h1>

    <div class="table-container">

    <table>

        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Location</th>
            <th>Hobby</th>
            <th>Actions</th>
        </tr>

        <?php

        while ($row = mysqli_fetch_assoc($result)) 
        {

        ?>

        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['first_name']; ?></td>
            <td><?php echo $row['last_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['location']; ?></td>
            <td><?php echo $row['hobby']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit-btn">
                    Edit
                </a>
                <a href="delete.php?id=<?php echo $row['id']; ?>" class="delete-btn">
                    Delete
                </a>
            </td>
        </tr>

        <?php

        }

        ?>

    
    </table>
    

    <div class="add-user-container">

        <a href="index.html" class="add-btn">
            + Add User
        </a>

    </div>

</body>

</html>