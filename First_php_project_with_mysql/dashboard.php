<?php
include "db.php";

/* Check whether a column exists in the users table */
function columnExists($conn, $table, $column)
{
    $allowedTables = ["users"];

    if (!in_array($table, $allowedTables, true)) {
        return false;
    }

    $column = mysqli_real_escape_string($conn, $column);
    $result = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");

    return $result && mysqli_num_rows($result) > 0;
}

/* Total Employees */
$total_employees = 0;

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");

if ($result) {
    $total_employees = (int) mysqli_fetch_assoc($result)['total'];
}

/* Active Employees */
$active_employees = 0;

if (columnExists($conn, "users", "employment_status")) {
    $result = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM users
         WHERE employment_status = 'Active'"
    );

    if ($result) {
        $active_employees = (int) mysqli_fetch_assoc($result)['total'];
    }
}

/* New Employees This Month */
$new_employees = 0;

if (columnExists($conn, "users", "joining_date")) {
    $result = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM users
         WHERE joining_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
         AND joining_date < DATE_ADD(
             DATE_FORMAT(CURDATE(), '%Y-%m-01'),
             INTERVAL 1 MONTH
         )"
    );

    if ($result) {
        $new_employees = (int) mysqli_fetch_assoc($result)['total'];
    }
}

/* Monthly Salary: latest effective salary record per employee */
$monthly_salary = 0;

$sql = "
    SELECT COALESCE(SUM(
        CASE
            WHEN sh.pay_frequency = 'Annual'
                THEN COALESCE(sh.annual_base_salary, 0) / 12
            ELSE COALESCE(sh.base_salary, 0)
        END
    ), 0) AS total_salary
    FROM salary_history sh
    INNER JOIN (
        SELECT user_id, MAX(effective_date) AS latest_date
        FROM salary_history
        WHERE effective_date <= CURDATE()
        GROUP BY user_id
    ) latest
        ON latest.user_id = sh.user_id
        AND latest.latest_date = sh.effective_date
";

$result = mysqli_query($conn, $sql);

if ($result) {
    $monthly_salary = (float) mysqli_fetch_assoc($result)['total_salary'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Dashboard</title>

    <link rel="stylesheet" href="CSS/dashboard.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="dashboard-container">

    <!-- HEADER -->
    <header class="dashboard-header">
        <a href="dashboard.php" class="brand">
            <span class="brand-icon">
                <i class="fa-solid fa-users"></i>
            </span>

            <span>
                <strong>PeopleHub</strong>
                <small>Employee Management</small>
            </span>
        </a>

        <div class="header-actions">
            <a href="user.php" class="btn btn-light">
                <i class="fa-solid fa-users"></i>
                Employees
            </a>

            <a href="index.html" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i>
                Add Employee
            </a>
        </div>
    </header>

    <!-- PAGE INTRODUCTION -->
    <section class="page-intro">
        <div>
            <span class="eyebrow">OVERVIEW</span>

            <h1>Dashboard</h1>

            <p>
                Welcome back! Here's your employee overview.
            </p>
        </div>

        <div class="today-date">
            <i class="fa-regular fa-calendar"></i>
            <?php echo date("d M Y"); ?>
        </div>
    </section>

    <!-- STATISTICS -->
    <section class="stats-grid">

        <article class="stat-card">
            <div class="stat-top">
                <span class="stat-icon icon-blue">
                    <i class="fa-solid fa-users"></i>
                </span>

                <span class="stat-label">EMPLOYEES</span>
            </div>

            <p class="stat-title">Total Employees</p>

            <h2><?php echo number_format($total_employees); ?></h2>

            <div class="stat-footer">
                <i class="fa-solid fa-address-book"></i>
                All registered employee records
            </div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <span class="stat-icon icon-green">
                    <i class="fa-solid fa-user-check"></i>
                </span>

                <span class="stat-label">WORKFORCE</span>
            </div>

            <p class="stat-title">Active Employees</p>

            <h2><?php echo number_format($active_employees); ?></h2>

            <div class="stat-footer">
                <i class="fa-solid fa-circle-check"></i>

                <?php
                echo columnExists($conn, "users", "employment_status")
                    ? "Currently active employees"
                    : "Add employment status to track";
                ?>
            </div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <span class="stat-icon icon-purple">
                    <i class="fa-solid fa-wallet"></i>
                </span>

                <span class="stat-label">PAYROLL</span>
            </div>

            <p class="stat-title">Monthly Salary</p>

            <h2 class="salary-value">
                ₹<?php echo number_format($monthly_salary, 2); ?>
            </h2>

            <div class="stat-footer">
                <i class="fa-solid fa-indian-rupee-sign"></i>
                Estimated monthly base salary
            </div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <span class="stat-icon icon-orange">
                    <i class="fa-solid fa-user-plus"></i>
                </span>

                <span class="stat-label">THIS MONTH</span>
            </div>

            <p class="stat-title">New Employees</p>

            <h2><?php echo number_format($new_employees); ?></h2>

            <div class="stat-footer">
                <i class="fa-regular fa-calendar-days"></i>

                <?php
                echo columnExists($conn, "users", "joining_date")
                    ? "Joined in " . date("F Y")
                    : "Add joining date to track";
                ?>
            </div>
        </article>

    </section>

    <!-- MAIN CONTENT -->
    <section class="content-grid">

        <!-- QUICK ACTIONS -->
        <div class="panel actions-panel">
            <div class="panel-heading">
                <div>
                    <h2>Quick Actions</h2>
                    <p>Manage your employee records</p>
                </div>

                <span class="heading-icon">
                    <i class="fa-solid fa-bolt"></i>
                </span>
            </div>

            <div class="action-list">

                <a href="user.php" class="action-item">
                    <span class="action-icon icon-blue">
                        <i class="fa-solid fa-users"></i>
                    </span>

                    <span class="action-description">
                        <strong>View Employees</strong>
                        <small>Search, view and edit records</small>
                    </span>

                    <i class="fa-solid fa-chevron-right action-arrow"></i>
                </a>

                <a href="index.html" class="action-item">
                    <span class="action-icon icon-green">
                        <i class="fa-solid fa-user-plus"></i>
                    </span>

                    <span class="action-description">
                        <strong>Add Employee</strong>
                        <small>Register a new employee</small>
                    </span>

                    <i class="fa-solid fa-chevron-right action-arrow"></i>
                </a>

                <a href="export_excel.php" class="action-item">
                    <span class="action-icon icon-orange">
                        <i class="fa-solid fa-file-excel"></i>
                    </span>

                    <span class="action-description">
                        <strong>Export Excel</strong>
                        <small>Export your employee records</small>
                    </span>

                    <i class="fa-solid fa-chevron-right action-arrow"></i>
                </a>

            </div>
        </div>

        <!-- EMPLOYEE SUMMARY -->
        <div class="panel summary-panel">
            <div class="panel-heading">
                <div>
                    <h2>Workforce Summary</h2>
                    <p>Employee record overview</p>
                </div>

                <span class="heading-icon">
                    <i class="fa-solid fa-chart-pie"></i>
                </span>
            </div>

            <div class="summary-number">
                <span>Total records</span>
                <strong><?php echo number_format($total_employees); ?></strong>
            </div>

            <div class="summary-bar">
                <span class="summary-bar-active"
                    style="width: <?php
                        echo $total_employees > 0
                            ? min(100, ($active_employees / $total_employees) * 100)
                            : 0;
                    ?>%">
                </span>
            </div>

            <div class="summary-legend">
                <span>
                    <i class="legend-dot green-dot"></i>
                    Active employees
                </span>

                <strong>
                    <?php echo number_format($active_employees); ?>
                </strong>
            </div>

            <div class="summary-legend">
                <span>
                    <i class="legend-dot grey-dot"></i>
                    Other / unclassified records
                </span>

                <strong>
                    <?php
                    echo number_format(
                        max(0, $total_employees - $active_employees)
                    );
                    ?>
                </strong>
            </div>

            <a href="user.php" class="view-all-link">
                View all employees
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

    </section>

    <!-- SALARY HISTORY SHORTCUT -->
    <section class="payroll-banner">
        <div class="payroll-banner-icon">
            <i class="fa-solid fa-money-check-dollar"></i>
        </div>

        <div class="payroll-banner-text">
            <h2>Salary Management</h2>
            <p>
                Review employee salary history and manage salary records
                from the employee list.
            </p>
        </div>

        <a href="user.php" class="btn btn-light">
            View Employees
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </section>

    <!-- FOOTER -->
    <footer class="dashboard-footer">
        <span>
            &copy; <?php echo date("Y"); ?> PeopleHub
        </span>

        <span>Employee Management System</span>
    </footer>

</div>

</body>
</html>

