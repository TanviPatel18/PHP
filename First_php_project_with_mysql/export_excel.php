<?php

include "db.php";

/* Get all users */
$sql = "SELECT * FROM users";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}


/* CSV file name */
$filename = "users.csv";


/* Tell browser this is a CSV file */
header("Content-Type: text/csv");

header("Content-Disposition: attachment; filename=\"$filename\"");


/* Open output */
$output = fopen("php://output", "w");


/* CSV Header */

fputcsv($output, [
    "ID",
    "First Name",
    "Last Name",
    "Email",
    "Date of Birth",
    "Phone",
    "Location",
    "Hobby",
    "Image"
]);


/* User Data */

while ($row = mysqli_fetch_assoc($result)) {

    fputcsv($output, [
        $row['id'],
        $row['first_name'],
        $row['last_name'],
        $row['email'],
        $row['birth_date'],
        $row['phone'],
        $row['location'],
        $row['hobby'],
        $row['image']
    ]);

}


/* Close output */

fclose($output);

exit();

?>