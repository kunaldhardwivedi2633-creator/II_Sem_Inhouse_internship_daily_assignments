<?php
// admin/toggle_status.php - Switches a poll between active and inactive
require_once '../includes/functions.php';
require_once '../config/db.php';
require_admin_login();

$pollId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Get the current status
$stmt = mysqli_prepare($conn, "SELECT status FROM polls WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $pollId);
mysqli_stmt_execute($stmt);
$poll = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if ($poll) {
    // Flip active <-> inactive
    $newStatus = ($poll['status'] === 'active') ? 'inactive' : 'active';

    $upd = mysqli_prepare($conn, "UPDATE polls SET status = ? WHERE id = ?");
    mysqli_stmt_bind_param($upd, "si", $newStatus, $pollId);
    mysqli_stmt_execute($upd);
}

header("Location: dashboard.php");
exit();
?>
