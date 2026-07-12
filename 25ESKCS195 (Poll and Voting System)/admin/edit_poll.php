<?php
// admin/edit_poll.php - Edit poll question, add/edit/delete options
require_once '../includes/functions.php';
require_once '../config/db.php';
require_admin_login();

$pollId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$message = "";
$errors = [];

// Fetch the poll
$stmt = mysqli_prepare($conn, "SELECT * FROM polls WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $pollId);
mysqli_stmt_execute($stmt);
$poll = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$poll) {
    header("Location: dashboard.php");
    exit();
}

// ---- Handle form submissions ----
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'] ?? '';

    // 1) Update the poll question
    if ($action === 'update_question') {
        $newQuestion = clean_input($_POST['question']);
        if (empty($newQuestion)) {
            $errors[] = "Poll question cannot be empty.";
        } else {
            $upd = mysqli_prepare($conn, "UPDATE polls SET question = ? WHERE id = ?");
            mysqli_stmt_bind_param($upd, "si", $newQuestion, $pollId);
            mysqli_stmt_execute($upd);
            $poll['question'] = $newQuestion;
            $message = "Poll question updated.";
        }
    }

    // 2) Add a new option
    if ($action === 'add_option') {
        $optionText = clean_input($_POST['option_text']);
        if (empty($optionText)) {
            $errors[] = "Option text cannot be empty.";
        } else {
            $ins = mysqli_prepare($conn, "INSERT INTO poll_options (poll_id, option_text) VALUES (?, ?)");
            mysqli_stmt_bind_param($ins, "is", $pollId, $optionText);
            mysqli_stmt_execute($ins);
            $message = "Option added.";
        }
    }

    // 3) Edit an existing option
    if ($action === 'edit_option') {
        $optionId = (int) $_POST['option_id'];
        $optionText = clean_input($_POST['option_text']);
        if (empty($optionText)) {
            $errors[] = "Option text cannot be empty.";
        } else {
            $upd = mysqli_prepare($conn, "UPDATE poll_options SET option_text = ? WHERE id = ? AND poll_id = ?");
            mysqli_stmt_bind_param($upd, "sii", $optionText, $optionId, $pollId);
            mysqli_stmt_execute($upd);
            $message = "Option updated.";
        }
    }
}

// Fetch current options (with vote counts for reference)
$optQuery = "
    SELECT o.*, (SELECT COUNT(*) FROM votes v WHERE v.option_id = o.id) AS vote_count
    FROM poll_options o WHERE o.poll_id = ?
";
$optStmt = mysqli_prepare($conn, $optQuery);
mysqli_stmt_bind_param($optStmt, "i", $pollId);
mysqli_stmt_execute($optStmt);
$options = mysqli_fetch_all(mysqli_stmt_get_result($optStmt), MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Poll - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <?php include 'admin_navbar.php'; ?>

    <div class="form-wrapper" style="max-width:600px;">
        <h2>Edit Poll</h2>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error) echo htmlspecialchars($error) . "<br>"; ?>
            </div>
        <?php endif; ?>

        <!-- Update poll question -->
        <form action="edit_poll.php?id=<?php echo $pollId; ?>" method="POST">
            <input type="hidden" name="action" value="update_question">
            <div class="form-group">
                <label for="question">Poll Question</label>
                <input type="text" id="question" name="question" value="<?php echo htmlspecialchars($poll['question']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Question</button>
        </form>

        <hr style="margin:25px 0; border:none; border-top:1px solid var(--border);">

        <h3 style="margin-bottom:15px;">Poll Options</h3>

        <?php foreach ($options as $option): ?>
            <form action="edit_poll.php?id=<?php echo $pollId; ?>" method="POST" class="option-row">
                <input type="hidden" name="action" value="edit_option">
                <input type="hidden" name="option_id" value="<?php echo $option['id']; ?>">
                <input type="text" name="option_text" value="<?php echo htmlspecialchars($option['option_text']); ?>">
                <span style="font-size:12px; color:var(--text-light); white-space:nowrap;"><?php echo $option['vote_count']; ?> votes</span>
                <button type="submit" class="btn btn-primary btn-small">Save</button>
            </form>
            <form action="delete_option.php" method="POST" style="margin-bottom:15px;"
                  onsubmit="return confirm('Delete this option? Its votes will also be removed.');">
                <input type="hidden" name="option_id" value="<?php echo $option['id']; ?>">
                <input type="hidden" name="poll_id" value="<?php echo $pollId; ?>">
                <button type="submit" class="btn btn-danger btn-small">Delete This Option</button>
            </form>
        <?php endforeach; ?>

        <!-- Add new option -->
        <form action="edit_poll.php?id=<?php echo $pollId; ?>" method="POST" class="option-row">
            <input type="hidden" name="action" value="add_option">
            <input type="text" name="option_text" placeholder="New option text">
            <button type="submit" class="btn btn-success btn-small">Add Option</button>
        </form>

        <p class="form-footer-text"><a href="dashboard.php">&larr; Back to Dashboard</a></p>
    </div>

</body>
</html>
