<?php
// dashboard.php - Shows all active polls to a logged-in user
require_once 'includes/functions.php';
require_once 'config/db.php';
require_user_login(); // only logged-in users can see this page

// Get all active polls
$pollsQuery = "SELECT * FROM polls WHERE status = 'active' ORDER BY created_at DESC";
$pollsResult = mysqli_query($conn, $pollsQuery);

$userId = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PollVote</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'includes/navbar.php'; ?>

    <div class="page-heading">
        <h2>Active Polls</h2>
        <p>Select a poll below to cast your vote or view live results.</p>
    </div>

    <div class="poll-grid">
        <?php if (mysqli_num_rows($pollsResult) === 0): ?>
            <p class="empty-state">No active polls right now. Please check back later.</p>
        <?php else: ?>
            <?php while ($poll = mysqli_fetch_assoc($pollsResult)): ?>
                <?php
                    // Check whether this user has already voted in this poll
                    $checkVote = "SELECT id FROM votes WHERE poll_id = ? AND user_id = ?";
                    $stmt = mysqli_prepare($conn, $checkVote);
                    mysqli_stmt_bind_param($stmt, "ii", $poll['id'], $userId);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $hasVoted = mysqli_stmt_num_rows($stmt) > 0;
                    mysqli_stmt_close($stmt);

                    // Count total votes for this poll
                    $countQuery = "SELECT COUNT(*) as total FROM votes WHERE poll_id = ?";
                    $stmt2 = mysqli_prepare($conn, $countQuery);
                    mysqli_stmt_bind_param($stmt2, "i", $poll['id']);
                    mysqli_stmt_execute($stmt2);
                    $totalVotes = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt2))['total'];
                    mysqli_stmt_close($stmt2);
                ?>
                <div class="poll-card">
                    <div>
                        <h3><?php echo htmlspecialchars($poll['question']); ?></h3>
                        <div class="poll-meta">
                            <?php if ($hasVoted): ?>
                                <span class="badge badge-voted">You Voted</span>
                            <?php else: ?>
                                <span class="badge badge-active">Active</span>
                            <?php endif; ?>
                            &nbsp; <?php echo (int)$totalVotes; ?> total vote(s)
                        </div>
                    </div>
                    <a href="vote.php?id=<?php echo $poll['id']; ?>" class="btn btn-primary btn-block">
                        <?php echo $hasVoted ? "View Results" : "Vote Now"; ?>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <div class="footer">&copy; <?php echo date("Y"); ?> PollVote - College Mini Project</div>

</body>
</html>
