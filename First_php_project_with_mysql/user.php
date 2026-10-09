<?php 

    include "db.php";

    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    $count_sql = "SELECT COUNT(*) AS total_employees FROM users";
    $count_result = mysqli_query($conn, $count_sql);
    $count_data = mysqli_fetch_assoc($count_result);

    $total_employees = $count_data['total_employees'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Users</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet"
        href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">

    <!-- Only User Page CSS -->
    <link rel="stylesheet" href="CSS/user.css">

</head>

<body>
    <!-- ================= HEADER ================= -->
    <div class="user-list-header">
        <!-- LEFT -->
        <div class="user-title">
            <h1>Users List</h1>
           <span class="total-employees">
                Total Employees: <?php echo $total_employees; ?>
            </span>
        </div>

        <!-- CENTER -->
        <div class="user-search">
            <input
                type="text"
                id="userSearch"
                placeholder="Search users..."
            >
        </div>

        <!-- RIGHT -->
        <div class="header-buttons">

            <a href="index.html" class="add-btn">
                + Add User
            </a>
            <a href="dashboard.php" class="dashboard-btn">
                Dashboard
            </a>    
            <a href="export_excel.php" class="excel-btn">
                Export Excel
            </a>

        </div>


        <!-- LAST -->
        <div class="page-length" id="pageLengthContainer"></div>

    </div>


    <!-- ================= TABLE ================= -->

    <table id="usersTable" class="display">

        <thead>

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

        </thead>


        <tbody>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td>
                        <?php echo $row['id']; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['first_name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['last_name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['email']); ?>
                    </td>

                    <td>
                        <?php  echo date("d/m/Y", strtotime($row['birth_date'])); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['phone']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['location']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['hobby']); ?>
                    </td>


                    <!-- IMAGE -->

                    <td>

                        <?php if (!empty($row['image'])) { ?>

                            <a
                                href="uploads/<?php echo rawurlencode($row['image']); ?>"
                                target="_blank"
                            >

                                <img
                                    src="uploads/<?php echo rawurlencode($row['image']); ?>"
                                    alt="User Image"
                                    class="user-image"
                                >

                            </a>

                            <a
                                href="uploads/<?php echo rawurlencode($row['image']); ?>"
                                target="_blank"
                                class="image-name"
                            >
                                <?php echo htmlspecialchars($row['image']); ?>
                            </a>

                        <?php } ?>

                    </td>


                    <!-- ACTIONS -->

                    <td class="actions">
                        <a
                            href="user_details.php?id=<?php echo $row['id']; ?>"
                            class="details-btn"
                        >
                            Details
                        </a>

                        <a
                            href="edit.php?id=<?php echo $row['id']; ?>"
                            class="edit-btn"
                        >
                            Edit
                        </a>


                        <a
                            href="delete.php?id=<?php echo $row['id']; ?>"
                            class="delete-btn"
                            onclick="return confirm('Are you sure you want to delete this user?');"
                        >
                            Delete
                        </a>


                        <a
                            href="salary_history.php?id=<?php echo $row['id']; ?>"
                            class="details-btn"
                        >
                            Details
                        </a>

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>


    <!-- ================= jQuery ================= -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <!-- ================= DataTables JS ================= -->

    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>


    <!-- ================= DATA TABLE ================= -->

    <script>

        $(document).ready(function () {

            const table = $('#usersTable').DataTable({

                // Default 10 users
                pageLength: 4,

                // Dropdown values
                lengthMenu: [2,4,6,8,10],

                // Disable DataTables default search
                searching: true,

                // Enable column sorting
                ordering: true,

                // Enable pagination
                paging: true,

                search: {
                            caseInsensitive: false
                        },

                // DataTables layout
                layout: {
                            topStart: 'pageLength',
                            topEnd: null,
                            bottomStart: 'info',
                            bottomEnd: 'paging'
                        },

                language: {

                    // ONLY show dropdown
                    lengthMenu: "_MENU_",

                    info: "Showing _START_ to _END_ of _TOTAL_ users",

                    infoEmpty: "Showing 0 to 0 of 0 users",

                    zeroRecords: "No users found",

                    emptyTable: "No users available",

                    paginate: 
                            {
                                first: "",
                                previous: "Previous",
                                next: "Next",
                                last: ""
                            }

                }

            });


            // ================= CUSTOM SEARCH =================

            $('#userSearch').on('keyup', function () {

                table.search(this.value).draw();

            });


            // ================= MOVE 10 DROPDOWN =================

            const lengthBox = document.querySelector('.dt-length');

            const pageLengthContainer =
                document.getElementById('pageLengthContainer');

            if (lengthBox && pageLengthContainer) {

                pageLengthContainer.appendChild(lengthBox);

            }

        });

    </script>

</body>

</html>