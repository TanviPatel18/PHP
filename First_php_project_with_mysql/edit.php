<?php 
include "db.php";

$id=$_GET['id'];

$sql="select * FROM users WHERE id = $id ";

$result=mysqli_query($conn,$sql);

$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h1> Edit User</h1>
        <form action="update.php" method="POST">

            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class="form-group">
                <label>First Name</label>
                <input
                    type="text"
                    name="first_name"
                    value="<?php echo $row['first_name']; ?>"
                    required
                >
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input
                    type="text"
                    name="last_name"
                    value="<?php echo $row['last_name']; ?>"
                    required
                >
            </div>
            <div class="form-group">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    value="<?php echo $row['email']; ?>"
                    required
                >
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input
                    type="text"
                    name="phone"
                    value="<?php echo $row['phone']; ?>"
                    pattern="[0-9]{10}"
                    maxlength="10"
                    minlength="10"
                    required
                >
            </div>
            <div class="form-group">
                <label>Location</label>
                <input
                    type="text"
                    name="location"
                    value="<?php echo $row['location']; ?>"
                    required
                >
            </div>
            <div class="form-group">
                <label>Hobby</label>
                <input
                    type="text"
                    name="hobby"
                    value="<?php echo $row['hobby']; ?>"
                >
            </div>
            <div class="buttons">
                <button type="submit" class="save-btn">
                    Update
                </button>
                <a href="user.php" class="cancel-btn">
                    Cancel
                </a>
            </div>

        </form>
    </div>
    
</body>
</html>