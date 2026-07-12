<?php
// admin/login.php - Admin login page
require_once '../includes/functions.php';
require_once '../config/db.php';

if (is_admin_logged_in()) {
    header("Location: dashboard.php");
    exit();
}

$errors = [];
$username = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = clean_input($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $errors[] = "Both username and password are required.";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, username, password FROM admin WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($admin = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                header("Location: dashboard.php");
                exit();
            } else {
                $errors[] = "Incorrect username or password.";
            }
        } else {
            $errors[] = "Incorrect username or password.";
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
    <title>Admin Login - PollVote</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">🗳️ PollVote</a>
        </div>
    </nav>

    <div class="form-wrapper">
        <h2>Admin Login</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error) echo htmlspecialchars($error) . "<br>"; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>

            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <p class="form-footer-text"><a href="../login.php">&larr; Back to user login</a></p>
    </div>

</body>
</html>
