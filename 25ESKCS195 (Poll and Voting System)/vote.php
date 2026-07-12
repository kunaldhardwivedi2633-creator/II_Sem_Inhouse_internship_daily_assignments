<?php
// vote.php - Handles displaying poll options and submitting a vote
require_once 'includes/functions.php';
require_once 'config/db.php';
require_user_login();

$userId = $_SESSION['user_id'];
$successMessage = "";
$errorMessage = "";

// Get poll ID from the URL, e.g. vote.php?id=1
$pollId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Fetch the poll details
$pollStmt = mysqli_prepare($conn, "SELECT * FROM polls WHERE id = ? AND status = 'active'");
mysqli_stmt_bind_param($pollStmt, "i", $pollId);
mysqli_stmt_execute($pollStmt);
$poll = mysqli_fetch_assoc(mysqli_stmt_get_result($pollStmt));

// If the poll does not exist or is inactive, send the user back
if (!$poll) {
    header("Location: dashboard.php");
    exit();
}

// ---- Function: check if this user already voted in this poll ----
function userHasVoted($conn, $pollId, $userId) {
    $stmt = mysqli_prepare($conn, "SELECT option_id FROM votes WHERE poll_id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $pollId, $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row ? $row['option_id'] : false; // returns option_id voted for, or false
}

$votedOptionId = userHasVoted($conn, $pollId, $userId);

// ---- Handle vote submission ----
if ($_SERVER["REQUEST_METHOD"] === "POST" && !$votedOptionId) {
    $optionId = isset($_POST['option_id']) ? (int) $_POST['option_id'] : 0;

    if ($optionId <= 0) {
        $errorMessage = "Please select an option before voting.";
    } else {
        // Double-check on the server that the user has not already voted
        // (prevents duplicate voting even if someone bypasses the JS/UI)
        if (userHasVoted($conn, $pollId, $userId)) {
            $errorMessage = "You have already voted in this poll.";
        } else {
            $insertStmt = mysqli_prepare($conn, "INSERT INTO votes (poll_id, option_id, user_id) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($insertStmt, "iii", $pollId, $optionId, $userId);

            if (mysqli_stmt_execute($insertStmt)) {
                $successMessage = "Your vote has been recorded successfully!";
                $votedOptionId = $optionId; // now show results
            } else {
                // The UNIQUE KEY (poll_id, user_id) in the votes table also
                // blocks duplicate votes at the database level as a safety net
                $errorMessage = "You have already voted in this poll.";
            }
            mysqli_stmt_close($insertStmt);
        }
    }
}

// Fetch all options for this poll
$optionsStmt = mysqli_prepare($conn, "SELECT * FROM poll_options WHERE poll_id = ?");
mysqli_stmt_bind_param($optionsStmt, "i", $pollId);
mysqli_stmt_execute($optionsStmt);
$optionsResult = mysqli_stmt_get_result($optionsStmt);
$options = mysqli_fetch_all($optionsResult, MYSQLI_ASSOC);

// Calculate total votes for the poll (used for progress bar percentages)
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
    <title><?php echo htmlspecialchars($poll['question']); ?> - PollVote</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'includes/navbar.php'; ?>

    <div class="form-wrapper" style="max-width:550px;">
        <h2><?php echo htmlspecialchars($poll['question']); ?></h2>

        <?php if ($successMessage): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>

        <?php if (!$votedOptionId): ?>
            <!-- User has NOT voted yet: show the voting form -->
            <form id="voteForm" action="vote.php?id=<?php echo $pollId; ?>" method="POST">
                <ul class="option-list">
                    <?php foreach ($options as $option): ?>
                        <li class="option-item">
                            <label style="display:flex; align-items:center; gap:10px; cursor:pointer; width:100%;">
                                <input type="radio" name="option_id" value="<?php echo $option['id']; ?>">
                                <?php echo htmlspecialchars($option['option_text']); ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <button type="submit" class="btn btn-primary btn-block">Submit Vote</button>
            </form>
        <?php else: ?>
            <!-- User HAS voted: show live results with progress bars -->
            <div class="results-wrapper">
                <?php foreach ($options as $option): ?>
                    <?php
                        $voteStmt = mysqli_prepare($conn, "SELECT COUNT(*) as cnt FROM votes WHERE option_id = ?");
                        mysqli_stmt_bind_param($voteStmt, "i", $option['id']);
                        mysqli_stmt_execute($voteStmt);
                        $optionVotes = mysqli_fetch_assoc(mysqli_stmt_get_result($voteStmt))['cnt'];
                        $percentage = $totalVotes > 0 ? round(($optionVotes / $totalVotes) * 100) : 0;
                        $isYourChoice = ($option['id'] == $votedOptionId);
                    ?>
                    <div class="result-item">
                        <div class="result-label">
                            <span><?php echo htmlspecialchars($option['option_text']); ?> <?php echo $isYourChoice ? "✅ (Your vote)" : ""; ?></span>
                            <span><?php echo $optionVotes; ?> votes (<?php echo $percentage; ?>%)</span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: <?php echo $percentage; ?>%;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <p class="total-votes-text">Total votes: <?php echo (int)$totalVotes; ?></p>
            </div>
        <?php endif; ?>

        <p class="form-footer-text"><a href="dashboard.php">&larr; Back to Dashboard</a></p>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
