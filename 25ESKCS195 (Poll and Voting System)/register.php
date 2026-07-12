<?php
// register.php - New user registration
require_once 'includes/functions.php';
require_once 'config/db.php';

// If already logged in, go straight to dashboard
if (is_user_logged_in()) {
    header("Location: dashboard.php");
    exit();
}

$errors = [];
$name = $email = "";

// Only process the form when it is submitted (POST request)
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = clean_input($_POST['name']);
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // ---- Required field validation ----
    if (empty($name)) {
        $errors[] = "Full name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // ---- Email validation ----
        $errors[] = "Please enter a valid email address.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        // ---- Password validation ----
        $errors[] = "Password must be at least 6 characters long.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // ---- Check if the email is already registered ----
    if (empty($errors)) {
        $checkQuery = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors[] = "This email is already registered. Please login instead.";
        }
        mysqli_stmt_close($stmt);
    }

    // ---- Insert the new user into the database ----
    if (empty($errors)) {
        // Hash the password before saving it - NEVER store plain text passwords
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertQuery = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPassword);

        if (mysqli_stmt_execute($stmt)) {
            // Registration success - redirect to login page with a message
            header("Location: login.php?registered=1");
            exit();
        } else {
            $errors[] = "Something went wrong. Please try again.";
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
    <title>Register - PollVote</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'includes/navbar.php'; ?>

    <div class="form-wrapper">
        <h2>Create an Account</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error) echo htmlspecialchars($error) . "<br>"; ?>
            </div>
        <?php endif; ?>

        <form id="registerForm" action="register.php" method="POST" novalidate>
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password">
            </div>

            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>

        <p class="form-footer-text">Already have an account? <a href="login.php">Login here</a></p>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
