<?php
// admin/dashboard.php - Main admin panel screen
require_once '../includes/functions.php';
require_once '../config/db.php';
require_admin_login();

// ---- Stats for the top of the dashboard ----
$totalPolls = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM polls"))['c'];
$totalActivePolls = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM polls WHERE status='active'"))['c'];
$totalVotes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM votes"))['c'];
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM users"))['c'];

// ---- Fetch all polls along with their vote counts ----
$pollsQuery = "
    SELECT p.*, 
           (SELECT COUNT(*) FROM votes v WHERE v.poll_id = p.id) AS vote_count
    FROM polls p
    ORDER BY p.created_at DESC
";
$pollsResult = mysqli_query($conn, $pollsQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PollVote</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <?php include 'admin_navbar.php'; ?>

    <div class="page-heading">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></h2>
        <p>Here is an overview of your polling system.</p>
    </div>

    <!-- Stat cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo $totalPolls; ?></div>
            <div class="stat-label">Total Polls</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $totalActivePolls; ?></div>
            <div class="stat-label">Active Polls</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $totalVotes; ?></div>
            <div class="stat-label">Total Votes Cast</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $totalUsers; ?></div>
            <div class="stat-label">Registered Users</div>
        </div>
    </div>

    <div class="page-heading">
        <h2>All Polls</h2>
    </div>

    <div class="container" style="margin-bottom:60px; overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Status</th>
                    <th>Total Votes</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($pollsResult) === 0): ?>
                    <tr><td colspan="6">No polls created yet.</td></tr>
                <?php else: ?>
                    <?php $i = 1; while ($poll = mysqli_fetch_assoc($pollsResult)): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($poll['question']); ?></td>
                            <td>
                                <?php if ($poll['status'] === 'active'): ?>
                                    <span class="badge badge-active">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-inactive">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $poll['vote_count']; ?></td>
                            <td><?php echo date("d M Y", strtotime($poll['created_at'])); ?></td>
                            <td class="action-links">
                                <a href="edit_poll.php?id=<?php echo $poll['id']; ?>" class="btn btn-primary btn-small">Edit</a>
                                <a href="results.php?id=<?php echo $poll['id']; ?>" class="btn btn-success btn-small">Results</a>
                                <a href="toggle_status.php?id=<?php echo $poll['id']; ?>"
                                   class="btn btn-small"
                                   style="background:#f0ad4e; color:#fff;">
                                    <?php echo $poll['status'] === 'active' ? 'Deactivate' : 'Activate'; ?>
                                </a>
                                <a href="delete_poll.php?id=<?php echo $poll['id']; ?>"
                                   class="btn btn-danger btn-small"
                                   onclick="return confirm('Delete this poll and all its votes? This cannot be undone.');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">&copy; <?php echo date("Y"); ?> PollVote Admin Panel</div>

</body>
</html>
