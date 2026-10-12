 
<?php

include "db.php";

$user_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($user_id <= 0) {
    die("Invalid user ID.");
}

// Get employee details using a prepared statement
$user_stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM users WHERE id = ?"
);

mysqli_stmt_bind_param($user_stmt, "i", $user_id);
mysqli_stmt_execute($user_stmt);

$user_result = mysqli_stmt_get_result($user_stmt);

if (!$user_result || mysqli_num_rows($user_result) === 0) {
    die("User not found.");
}

$user = mysqli_fetch_assoc($user_result);

$error = "";

// Save salary history
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $effective_date = $_POST['effective_date'] ?? '';
    $job_role = trim($_POST['job_role'] ?? '');
    $employee_type = $_POST['employee_type'] ?? '';
    $base_salary = $_POST['base_salary'] ?? '';
    $annual_base_salary = $_POST['annual_base_salary'] ?? '';
    $pay_frequency = $_POST['pay_frequency'] ?? '';
    $currency = $_POST['currency'] ?? '';

    if (
        $effective_date === '' ||
        $job_role === '' ||
        $employee_type === '' ||
        $base_salary === '' ||
        $annual_base_salary === '' ||
        $pay_frequency === '' ||
        $currency === '' ||
        !is_numeric($base_salary) ||
        !is_numeric($annual_base_salary) ||
        (float)$base_salary < 0 ||
        (float)$annual_base_salary < 0
    ) {
        $error = "Please enter valid values in all required fields.";
    } else {

        $sql = "INSERT INTO salary_history
                (
                    user_id,
                    effective_date,
                    job_role,
                    employee_type,
                    base_salary,
                    annual_base_salary,
                    pay_frequency,
                    currency
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "isssddss",
            $user_id,
            $effective_date,
            $job_role,
            $employee_type,
            $base_salary,
            $annual_base_salary,
            $pay_frequency,
            $currency
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: salary_history.php?id=" . $user_id);
            exit();
        } else {
            $error = "Unable to save salary history. Please try again.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Add Salary History -
        <?php echo htmlspecialchars($user['first_name']); ?>
        <?php echo htmlspecialchars($user['last_name']); ?>
    </title>

    <link rel="stylesheet" href="CSS/add_salary_history.css">

</head>

<body>

<div class="salary-form-page">

    <!-- PAGE HEADER -->

    <div class="page-header">

        <div>
            <h1>Add Salary History</h1>
            <p>Add a new salary record for the employee.</p>
        </div>

        <a
            href="salary_history.php?id=<?php echo $user_id; ?>"
            class="back-btn"
        >
            ← Back
        </a>

    </div>


    <!-- EMPLOYEE CARD -->

    <div class="employee-card">

        <div class="employee-image">

            <?php if (!empty($user['image'])) { ?>

                <img
                    src="uploads/<?php echo rawurlencode(basename($user['image'])); ?>"
                    alt="Employee Image"
                >
            <?php } else { ?>
                <div class="no-image">
                    <?php
                    echo strtoupper(substr($user['first_name'], 0, 1));
                    ?>
                </div>
            <?php } ?>

        </div>


        <div class="employee-info">

            <h2>
                <?php echo htmlspecialchars($user['first_name']); ?>
                <?php echo htmlspecialchars($user['last_name']); ?>
            </h2>

            <span>
                <?php echo htmlspecialchars($user['email']); ?>
            </span>

            <?php if (!empty($user['phone'])): ?>

                <span>
                    <?php echo htmlspecialchars($user['phone']); ?>
                </span>

            <?php endif; ?>

        </div>

    </div>


    <!-- FORM CARD -->

    <div class="form-card">

        <div class="form-header">

            <h2>Salary Information</h2>

            <p>
                Enter the employee's salary details.
            </p>

        </div>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>


        <form method="POST">


            <!-- ROW 1 -->

            <div class="form-row">

                <div class="form-group">

                    <label for="effective_date">
                        Effective Date <span>*</span>
                    </label>

                    <input
                        type="date"
                        id="effective_date"
                        name="effective_date"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="job_role">
                        Job Role <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="job_role"
                        name="job_role"
                        placeholder="e.g. Software Developer"
                        required
                    >

                </div>

            </div>


            <!-- ROW 2 -->

            <div class="form-row">

                <div class="form-group">

                    <label for="employee_type">
                        Employee Type <span>*</span>
                    </label>

                    <select
                        id="employee_type"
                        name="employee_type"
                        required
                    >

                        <option value="">
                            Select employee type
                        </option>

                        <option value="Full Time">
                            Full Time
                        </option>

                        <option value="Part Time">
                            Part Time
                        </option>

                        <option value="Contract">
                            Contract
                        </option>

                        <option value="Intern">
                            Intern
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="pay_frequency">
                        Pay Frequency <span>*</span>
                    </label>

                    <select
                        id="pay_frequency"
                        name="pay_frequency"
                        required
                    >

                        <option value="">
                            Select frequency
                        </option>

                        <option value="Monthly">
                            Monthly
                        </option>

                        <option value="Weekly">
                            Weekly
                        </option>

                        <option value="Biweekly">
                            Biweekly
                        </option>

                        <option value="Yearly">
                            Yearly
                        </option>

                    </select>

                </div>

            </div>


            <!-- ROW 3 -->

            <div class="form-row">

                <div class="form-group">

                    <label for="base_salary">
                        Base Salary <span>*</span>
                    </label>

                    <input
                        type="number"
                        id="base_salary"
                        name="base_salary"
                        placeholder="e.g. 35000"
                        min="0"
                        step="0.01"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="annual_base_salary">
                        Annual Base Salary <span>*</span>
                    </label>

                    <input
                        type="number"
                        id="annual_base_salary"
                        name="annual_base_salary"
                        placeholder="e.g. 420000"
                        min="0"
                        step="0.01"
                        required
                    >

                </div>

            </div>


            <!-- ROW 4 -->

            <div class="form-row">

                <div class="form-group">

                    <label for="currency">
                        Currency <span>*</span>
                    </label>

                    <select
                        id="currency"
                        name="currency"
                        required
                    >

                        <option value="INR">
                            INR - Indian Rupee
                        </option>

                        <option value="USD">
                            USD - US Dollar
                        </option>

                        <option value="EUR">
                            EUR - Euro
                        </option>

                        <option value="GBP">
                            GBP - British Pound
                        </option>

                    </select>

                </div>

                <div class="form-group"></div>

            </div>


            <!-- BUTTONS -->

            <div class="form-actions">

                <a
                    href="salary_history.php?id=<?php echo $user_id; ?>"
                    class="cancel-btn"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="save-btn"
                >
                    Save Salary History
                </button>

            </div>

        </form>

    </div>

</div>

</body>

</html>