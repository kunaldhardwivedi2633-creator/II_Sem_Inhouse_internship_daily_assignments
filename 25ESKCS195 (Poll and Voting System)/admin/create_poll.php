<?php
// admin/create_poll.php - Create a new poll with its options
require_once '../includes/functions.php';
require_once '../config/db.php';
require_admin_login();

$errors = [];
$question = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $question = clean_input($_POST['question']);
    $options = isset($_POST['options']) ? $_POST['options'] : [];

    // Remove any empty option fields the user left blank
    $options = array_filter(array_map('trim', $options), function ($val) {
        return $val !== "";
    });

    // ---- Required field validation ----
    if (empty($question)) {
        $errors[] = "Poll question is required.";
    }
    if (count($options) < 2) {
        $errors[] = "Please provide at least 2 options.";
    }

    if (empty($errors)) {
        // Insert the poll
        $stmt = mysqli_prepare($conn, "INSERT INTO polls (question, status) VALUES (?, 'active')");
        mysqli_stmt_bind_param($stmt, "s", $question);
        mysqli_stmt_execute($stmt);
        $newPollId = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);

        // Insert each option
        $optionStmt = mysqli_prepare($conn, "INSERT INTO poll_options (poll_id, option_text) VALUES (?, ?)");
        foreach ($options as $optionText) {
            $optionText = clean_input($optionText);
            mysqli_stmt_bind_param($optionStmt, "is", $newPollId, $optionText);
            mysqli_stmt_execute($optionStmt);
        }
        mysqli_stmt_close($optionStmt);

        header("Location: dashboard.php?created=1");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Poll - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <?php include 'admin_navbar.php'; ?>

    <div class="form-wrapper" style="max-width:550px;">
        <h2>Create New Poll</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error) echo htmlspecialchars($error) . "<br>"; ?>
            </div>
        <?php endif; ?>

        <form action="create_poll.php" method="POST">
            <div class="form-group">
                <label for="question">Poll Question</label>
                <input type="text" id="question" name="question" placeholder="e.g. What is your favorite season?" value="<?php echo htmlspecialchars($question); ?>">
            </div>

            <div class="form-group">
                <label>Poll Options (at least 2)</label>
                <div id="optionsContainer">
                    <div class="option-row">
                        <input type="text" name="options[]" placeholder="Option 1">
                    </div>
                    <div class="option-row">
                        <input type="text" name="options[]" placeholder="Option 2">
                    </div>
                </div>
                <button type="button" id="addOptionBtn" class="btn btn-outline" style="color:var(--primary); border-color:var(--primary); margin-top:5px;">+ Add Another Option</button>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Create Poll</button>
        </form>
    </div>

    <script src="../js/script.js"></script>
</body>
</html>
