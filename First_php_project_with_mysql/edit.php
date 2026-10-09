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
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="form-container">
        <h1> Edit User</h1>
        <form action="update.php" method="POST" enctype="multipart/form-data">

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
                <label>Date of Birth</label>
                <input
                    type="date"
                    name="birth_date"
                    value="<?php echo $row['birth_date']; ?>"
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
            <div class="form-group">

                <label>Image</label>

                <?php if (!empty($row['image'])) { ?>

                    <div class="image-preview">

                        <img
                            src="uploads/<?php echo $row['image']; ?>"
                            alt="Image"
                            width="100"
                            height="100"
                        >

                        <button
                            type="submit"
                            name="delete_image"
                            value="1"
                            class="delete-image-btn">
                            ×
                        </button>

                    </div>

                <?php } ?>

                <br>

                <input
                    type="file"
                    name="image"
                    accept=".jpg, .jpeg, .png"
                >

                <small>
                    Allowed formats: JPG, JPEG, PNG
                </small>

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