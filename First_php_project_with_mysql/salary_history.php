<?php

include "db.php";


/* =========================================================
   GET USER ID
   ========================================================= */

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("User ID is missing.");
}

$user_id = intval($_GET['id']);


/* =========================================================
   GET USER
   ========================================================= */

$user_sql = "SELECT * FROM users WHERE id = $user_id";

$user_result = mysqli_query($conn, $user_sql);

if (!$user_result || mysqli_num_rows($user_result) == 0) {
    die("User not found.");
}

$user = mysqli_fetch_assoc($user_result);


/* =========================================================
   GET SALARY HISTORY
   ========================================================= */

$sql = "
    SELECT *
    FROM salary_history
    WHERE user_id = $user_id
    ORDER BY effective_date DESC
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error loading salary history: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Salary History
        
    </title>


    <!-- =====================================================
         DATATABLES CSS CDN
         ===================================================== -->

    <link
        rel="stylesheet"
        href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css"
    >


    <!-- SALARY HISTORY CSS -->

    <link
        rel="stylesheet"
        href="CSS/salary-history.css"
    >

</head>


<body>


<div class="salary-page">


    <!-- =====================================================
         PAGE HEADER
         ===================================================== -->

    <div class="page-header">

        <div>

            <h1>
                Salary History
            </h1>

        </div>


        <a
            href="user.php"
            class="back-btn"
        >
            ← Back
        </a>

    </div>



    <!-- =====================================================
         EMPLOYEE INFORMATION
         ===================================================== -->

    <div class="employee-card">


        <!-- IMAGE -->

        <div class="employee-image">

            <?php if (!empty($user['image'])) { ?>

                <img
                    src="uploads/<?php echo rawurlencode($user['image']); ?>"
                    alt="Employee Image"
                >

            <?php } else { ?>

                <div class="no-image">

                    <?php
                    echo strtoupper(
                        substr(
                            $user['first_name'],
                            0,
                            1
                        )
                    );
                    ?>

                </div>

            <?php } ?>

        </div>



        <!-- EMPLOYEE DETAILS -->

        <div class="employee-info">

            <h2>

                <?php
                echo htmlspecialchars($user['first_name']);
                ?>

                <?php
                echo htmlspecialchars($user['last_name']);
                ?>

            </h2>


            <span>

                <?php
                echo htmlspecialchars($user['email']);
                ?>

            </span>


            <span>

                <?php
                echo htmlspecialchars($user['phone']);
                ?>

            </span>


            <span>

                <?php
                echo htmlspecialchars($user['location']);
                ?>

            </span>

        </div>

    </div>



    <!-- =====================================================
         SALARY HISTORY SECTION
         ===================================================== -->

    <div class="section-card">


        <!-- SECTION HEADER -->

        <div class="section-header">

            <h2>
                Salary History
            </h2>


            <a
                href="add_salary_history.php?id=<?php echo $user_id; ?>"
                class="add-salary-btn"
            >
                ⊕ Add salary history record
            </a>

        </div>



        <!-- =================================================
             SALARY TABLE
             ================================================= -->

        <div class="table-wrapper">

            <table
                id="salaryTable"
                class="display"
                style="width:100%"
            >

                <thead>

                    <tr>

                        <th>
                            Effective Date
                        </th>

                        <th>
                            Job Role
                        </th>

                        <th>
                            Employee Type
                        </th>

                        <th>
                            Base Salary
                        </th>

                        <th>
                            Annual Base Salary
                        </th>

                        <th>
                            Pay Frequency
                        </th>

                        <th>
                            Currency
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <?php

                    if (mysqli_num_rows($result) > 0) {

                        while (
                            $salary =
                            mysqli_fetch_assoc($result)
                        ) {

                    ?>

                        <tr>


                            <!-- EFFECTIVE DATE -->

                            <td>

                                <?php

                                if (
                                    !empty(
                                        $salary['effective_date']
                                    )
                                ) {

                                    echo date(
                                        "d/m/Y",
                                        strtotime(
                                            $salary['effective_date']
                                        )
                                    );

                                }

                                ?>

                            </td>



                            <!-- JOB ROLE -->

                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $salary['job_role']
                                );

                                ?>

                            </td>



                            <!-- EMPLOYEE TYPE -->

                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $salary['employee_type']
                                );

                                ?>

                            </td>



                            <!-- BASE SALARY -->

                            <td>

                                <?php

                                echo number_format(
                                    (float)$salary['base_salary'],
                                    2
                                );

                                ?>

                            </td>



                            <!-- ANNUAL BASE SALARY -->

                            <td>

                                <?php

                                echo number_format(
                                    (float)$salary['annual_base_salary'],
                                    2
                                );

                                ?>

                            </td>



                            <!-- PAY FREQUENCY -->

                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $salary['pay_frequency']
                                );

                                ?>

                            </td>



                            <!-- CURRENCY -->

                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $salary['currency']
                                );

                                ?>

                            </td>


                        </tr>


                    <?php

                        }

                    }

                    ?>

                </tbody>

            </table>

        </div>

    </div>


</div>



<!-- =========================================================
     JQUERY CDN
     ========================================================= -->

<script
    src="https://code.jquery.com/jquery-3.7.1.min.js">
</script>


<!-- =========================================================
     DATATABLES JS CDN
     ========================================================= -->

<script
    src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js">
</script>



<!-- =========================================================
     DATATABLE INITIALIZATION
     ========================================================= -->

    <script>
    $(document).ready(function () {

        $('#salaryTable').DataTable({
            pageLength: 2,
            lengthMenu: [2, 4, 6, 8, 10],

            searching: true,
            ordering: true,
            paging: true,

            // Case-sensitive search
            search: {
                caseInsensitive: true
            },

            // Keep Previous, page numbers, and Next
            pagingType: "simple_numbers",

            layout: {
                topStart: 'pageLength',
                topEnd: 'search',
                bottomStart: 'info',
                bottomEnd: 'paging'
            },

            language: {
                lengthMenu: "_MENU_",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                search: "Search:",
                zeroRecords: "No matching salary records found",
                emptyTable: "No salary records available",
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }
            }
        });

    });
    </script>


</body>

</html>