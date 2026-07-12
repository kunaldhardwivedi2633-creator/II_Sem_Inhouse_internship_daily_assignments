<?php
// login.php - User login
require_once 'includes/functions.php';
require_once 'config/db.php';

// If already logged in, go straight to dashboard
if (is_user_logged_in()) {
    header("Location: dashboard.php");
    exit();
}

$errors = [];
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];

    // ---- Required field validation ----
    if (empty($email) || empty($password)) {
        $errors[] = "Both email and password are required.";
    } else {
        // Look up the user by email
        $query = "SELECT id, name, password FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            // Verify the submitted password against the hashed password
            if (password_verify($password, $user['password'])) {
                // Correct login - save details in the session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: dashboard.php");
                exit();
            } else {
                $errors[] = "Incorrect email or password.";
            }
        } else {
            $errors[] = "Incorrect email or password.";
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
    <title>Login - PollVote</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'includes/navbar.php'; ?>

    <div class="form-wrapper">
        <h2>Login</h2>

        <?php if (isset($_GET['registered'])): ?>
            <div class="alert alert-success">Registration successful! Please login.</div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error) echo htmlspecialchars($error) . "<br>"; ?>
            </div>
        <?php endif; ?>

        <form id="loginForm" action="login.php" method="POST" novalidate>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>

            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <p class="form-footer-text">Don't have an account? <a href="register.php">Register here</a></p>
        <p class="form-footer-text"><a href="admin/login.php">Admin Login</a></p>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
