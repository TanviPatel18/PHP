<?php
    include "db.php";
    
    $id=$_GET['id'];

    $sql="select * FROM users where id=$id";
    
    $result=mysqli_query($conn,$sql);

    // $total_users=mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);

    if(!$row)
    {
        die("User not found");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER REPORT - <?php echo $row['id']; ?></title>
    <link rel="stylesheet" href="CSS/print.css">
</head>
<body>
     <div class="print-page">

        <!-- HEADER -->

        <div class="print-header">

            <div class="company-details">
                <h2>CRUD DATABASE</h2>
                <p>User Management System</p>
                <p>Ahmedabad, Gujarat</p>
                <p>+91 7567921292</p>
                <p>info@cruddatabase.com</p>
            </div>

            <div class="report-heading">
                <h1>USER REPORT</h1>
            </div>
        </div>
         <!-- REPORT INFORMATION -->
        <div class="details-title">
            <div>
                <strong>Report No:</strong>
                <?php echo $row['id']; ?>
            </div>

            <div>
                <strong>Date:</strong>
                <?php echo date("d/m/Y"); ?>
            </div>
        </div>
        <!-- USER DETAILS -->

        <div class="details-title">
            USER DETAILS
        </div>


        <table class="user-report-table">
            <tr>
                <th>ID</th>
                <td>
                    <?php echo $row['id']; ?>
                </td>
            </tr>
            <tr>
                <th>First Name</th>
                <td>
                    <?php echo htmlspecialchars($row['first_name']); ?>
                </td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td>
                    <?php echo htmlspecialchars($row['last_name']); ?>
                </td>
            </tr>
            <tr>
                <th>Email</th>
                <td>
                    <?php echo htmlspecialchars($row['email']); ?>
                </td>
            </tr>
            <tr>

                <th>Date of Birth</th>

                <td>
                    <?php echo htmlspecialchars($row['birth_date']); ?>
                </td>

            </tr>
            <tr>
                <th>Phone</th>
                <td>
                    <?php echo htmlspecialchars($row['phone']); ?>
                </td>
            </tr>
            <tr>
                <th>Location</th>
                <td>
                    <?php echo htmlspecialchars($row['location']); ?>
                </td>
            </tr>
            <tr>
                <th>Hobby</th>
                <td>
                    <?php echo htmlspecialchars($row['hobby']); ?>
                </td>
            </tr>
            <tr>

                <th>Image</th>

                <td>

                    <?php if (!empty($row['image'])) { ?>

                        <img
                            src="uploads/<?php echo rawurlencode($row['image']); ?>"
                            width="120"
                            height="120"
                            style="object-fit: cover;"
                        >
                        <!-- Image Name -->
                        <span>
                            <?php echo htmlspecialchars($row['image']); ?>
                        </span>

                    


                    <?php } else { ?>

                        No Image

                    <?php } ?>

                </td>

            </tr> 

        </table>
        <!-- FOOTER -->

        <div class="report-footer">

            <div class="thank-you">
                Thank You
            </div>

            <p>
                This report was generated from the CRUD Database System.
            </p>

        </div>


        <!-- BUTTONS -->

        <div class="print-actions">

            <button onclick="window.print()">
                Print Report
            </button>

            <button onclick="window.close()">
                Close
            </button>
        </div>
    </div>
    
</body>
</html>