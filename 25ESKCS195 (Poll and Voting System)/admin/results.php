<?php
// admin/results.php - View total votes and results for one poll
require_once '../includes/functions.php';
require_once '../config/db.php';
require_admin_login();

$pollId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = mysqli_prepare($conn, "SELECT * FROM polls WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $pollId);
mysqli_stmt_execute($stmt);
$poll = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$poll) {
    header("Location: dashboard.php");
    exit();
}

// Get options with their vote counts
$optQuery = "
    SELECT o.*, (SELECT COUNT(*) FROM votes v WHERE v.option_id = o.id) AS vote_count
    FROM poll_options o WHERE o.poll_id = ?
";
$optStmt = mysqli_prepare($conn, $optQuery);
mysqli_stmt_bind_param($optStmt, "i", $pollId);
mysqli_stmt_execute($optStmt);
$options = mysqli_fetch_all(mysqli_stmt_get_result($optStmt), MYSQLI_ASSOC);

// Total votes for this poll
$totalStmt = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM votes WHERE poll_id = ?");
mysqli_stmt_bind_param($totalStmt, "i", $pollId);
mysqli_stmt_execute($totalStmt);
$totalVotes = mysqli_fetch_assoc(mysqli_stmt_get_result($totalStmt))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poll Results - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <?php include 'admin_navbar.php'; ?>

    <div class="form-wrapper" style="max-width:600px;">
        <h2><?php echo htmlspecialchars($poll['question']); ?></h2>
        <p class="poll-meta" style="margin-bottom:20px;">
            <?php echo $poll['status'] === 'active' ? '<span class="badge badge-active">Active</span>' : '<span class="badge badge-inactive">Inactive</span>'; ?>
        </p>

        <?php foreach ($options as $option): ?>
            <?php $percentage = $totalVotes > 0 ? round(($option['vote_count'] / $totalVotes) * 100) : 0; ?>
            <div class="result-item">
                <div class="result-label">
                    <span><?php echo htmlspecialchars($option['option_text']); ?></span>
                    <span><?php echo $option['vote_count']; ?> votes (<?php echo $percentage; ?>%)</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: <?php echo $percentage; ?>%;"></div>
                </div>
            </div>
        <?php endforeach; ?>

        <p class="total-votes-text">Total votes: <?php echo (int)$totalVotes; ?></p>

        <p class="form-footer-text"><a href="dashboard.php">&larr; Back to Dashboard</a></p>
    </div>

</body>
</html>
