<?php
/*
    setup_admin.php
    ----------------------------------------------------
    Run this file ONCE in your browser after importing
    database.sql, to create the default admin account:

        username: admin
        password: admin123

    Visit: http://localhost/polling-voting-system/setup_admin.php

    After it works, DELETE this file for security -
    you don't want anyone else re-running it.
*/
require_once 'config/db.php';

$username = "admin";
$plainPassword = "admin123";

// Check if this admin already exists
$check = mysqli_query($conn, "SELECT id FROM admin WHERE username = '$username'");

if (mysqli_num_rows($check) > 0) {
    echo "Admin account already exists. You can delete this file now.";
} else {
    // Hash the password properly using PHP's own function
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO admin (username, password) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPassword);

    if (mysqli_stmt_execute($stmt)) {
        echo "Default admin account created successfully!<br>";
        echo "Username: admin<br>";
        echo "Password: admin123<br><br>";
        echo "<strong>Please delete setup_admin.php now for security.</strong>";
    } else {
        echo "Something went wrong: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
?>
