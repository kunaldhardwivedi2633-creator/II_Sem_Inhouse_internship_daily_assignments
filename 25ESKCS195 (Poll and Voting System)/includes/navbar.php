<?php
/*
    navbar.php
    ----------------------------------------------------
    Reusable navigation bar. Included at the top of every
    user-facing page (not the admin panel, which has its
    own navbar in admin/includes_nav.php).
*/
?>
<nav class="navbar">
    <div class="nav-container">
        <a href="index.php" class="nav-logo">🗳️ PollVote</a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <?php if (is_user_logged_in()): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><span class="nav-username">Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span></li>
                <li><a href="logout.php" class="btn-nav">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php" class="btn-nav">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
