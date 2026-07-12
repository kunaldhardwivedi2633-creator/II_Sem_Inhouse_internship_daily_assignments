<?php
// admin/delete_option.php - Deletes one poll option (and its votes, via ON DELETE CASCADE)
require_once '../includes/functions.php';
require_once '../config/db.php';
require_admin_login();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $optionId = (int) $_POST['option_id'];
    $pollId = (int) $_POST['poll_id'];

    $stmt = mysqli_prepare($conn, "DELETE FROM poll_options WHERE id = ? AND poll_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $optionId, $pollId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: edit_poll.php?id=" . $pollId);
    exit();
}

header("Location: dashboard.php");
exit();
?>
