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

    <div class="user-list-header">
        <h1>Users List</h1>
        <div class="header-buttons">

            <a href="index.html" class="add-btn">
                + Add User
            </a>

            <a href="export_excel.php" class="excel-btn">
                Export Excel
            </a>

        </div>

    </div>
    

    <table>

        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Date of Birth</th>
            <th>Phone</th>
            <th>Location</th>
            <th>Hobby</th>
            <th>Image</th>
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
            <td><?php echo $row['birth_date']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['location']; ?></td>
            <td><?php echo $row['hobby']; ?></td>
            <td>
                <?php if (!empty($row['image'])) { ?>

                    <a
                        href="http://localhost/first/uploads/<?php echo rawurlencode($row['image']); ?>"
                        target="_blank"
                    >
                        <img
                            src="uploads/<?php echo rawurlencode($row['image']); ?>"
                            alt="User Image"
                            width="80"
                            height="80"
                            style="object-fit: cover; display: block; margin-bottom: 5px;"
                        >
                    </a>

                    <a
                        href="http://localhost/first/uploads/<?php echo rawurlencode($row['image']); ?>"
                        target="_blank"
                    >
                        <?php echo htmlspecialchars($row['image']); ?>
                    </a>

                <?php } ?>
            </td>
            <td class="actions">
                <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit-btn">
                    Edit
                </a>
                 <a
                    href="delete.php?id=<?php echo $row['id']; ?>"
                    class="delete-btn"
                    onclick="return confirm('Are you sure you want to delete this user?');">
                    Delete
                </a>

                <a
                    href="print.php?id=<?php echo $row['id']; ?>"
                    class="print-btn"
                    target="_blank">
                    Print
                </a>

            </td>
        </tr>

        <?php
        }
        ?>
    </table>
    
</body>

</html>