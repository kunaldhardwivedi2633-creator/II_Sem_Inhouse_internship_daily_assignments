<?php
// index.php - Home page
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PollVote - Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'includes/navbar.php'; ?>

    <!-- Hero section -->
    <section class="hero">
        <h1>Make Your Voice Count 🗳️</h1>
        <p>Create polls, vote on topics you care about, and see live results instantly.</p>
        <div class="hero-buttons">
            <?php if (is_user_logged_in()): ?>
                <a href="dashboard.php" class="btn btn-outline">Go to Dashboard</a>
            <?php else: ?>
                <a href="register.php" class="btn btn-outline">Get Started</a>
                <a href="login.php" class="btn btn-outline">Login</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Feature highlights -->
    <section class="features">
        <div class="feature-card">
            <div class="feature-icon">📊</div>
            <h3>Live Results</h3>
            <p>Watch poll results update with clear, animated progress bars.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🔒</div>
            <h3>One Vote Policy</h3>
            <p>Every user can vote only once per poll, keeping results fair.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">⚡</div>
            <h3>Simple & Fast</h3>
            <p>Clean, mobile-friendly design that works on any device.</p>
        </div>
    </section>

    <div class="footer">&copy; <?php echo date("Y"); ?> PollVote - College Mini Project</div>

</body>
</html>
