<?php
/*
    db.php
    ----------------------------------------------------
    This file connects our PHP application to the MySQL
    database using mysqli (beginner-friendly, built into
    every XAMPP installation).

    If you change your MySQL username/password in XAMPP,
    update the values below.
*/

$db_host = "localhost";   // database server (XAMPP default)
$db_user = "root";        // database username (XAMPP default)
$db_pass = "";            // database password (XAMPP default is empty)
$db_name = "polling_system"; // database name (must match database.sql)

// Create the connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Stop the script and show an error if the connection failed
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
