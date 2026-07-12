<?php
// admin/delete_poll.php - Deletes a poll and (via ON DELETE CASCADE) its options and votes
require_once '../includes/functions.php';
require_once '../config/db.php';
require_admin_login();

$pollId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = mysqli_prepare($conn, "DELETE FROM polls WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $pollId);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: dashboard.php");
exit();
?>
