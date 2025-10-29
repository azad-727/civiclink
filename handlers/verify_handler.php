<?php
session_start();
require_once '../config/db_connect.php';

// Security Check: User must be logged in and submitting the form via POST.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SERVER["REQUEST_METHOD"] != "POST") {
    header("location: ../includes/login.php");
    exit;
}

// Get the issue ID from the form and the user ID from the session.
$issue_id = $_POST['issue_id'];
$user_id = $_SESSION['id'];

if (empty($issue_id)) {
    // Redirect back if the issue ID is missing.
    header("location: ../includes/explore.php");
    exit;
}

// --- LOGIC TO PREVENT DUPLICATE VERIFICATION ---
// 1. First, try to insert a record into the 'verifications' table.
$sql_insert = "INSERT INTO verifications (user_id, issue_id) VALUES (?, ?)";

if ($stmt_insert = mysqli_prepare($conn, $sql_insert)) {
    mysqli_stmt_bind_param($stmt_insert, "ii", $user_id, $issue_id);
    
    // 2. Execute the insert.
    if (mysqli_stmt_execute($stmt_insert)) {
        // --- SUCCESS: This is the user's first time verifying this issue. ---
        
        // 3. Now, increment the 'verify_count' in the 'issues' table.
        $sql_update = "UPDATE issues SET verify_count = verify_count + 1 WHERE id = ?";
        if ($stmt_update = mysqli_prepare($conn, $sql_update)) {
            mysqli_stmt_bind_param($stmt_update, "i", $issue_id);
            mysqli_stmt_execute($stmt_update);
            mysqli_stmt_close($stmt_update);
        }
        
        // Redirect back to the issue page with a success message.
        header("location: ../includes/issue_detail.php?id=$issue_id&status=verified");
        
    } else {
        // --- FAILURE: The insert failed. ---
        // This is almost certainly because the (user_id, issue_id) pair already exists,
        // thanks to our UNIQUE KEY constraint in the database.
        
        // Redirect back to the issue page with an 'already_verified' message.
        header("location: ../includes/issue_detail.php?id=$issue_id&status=already_verified");
    }
    mysqli_stmt_close($stmt_insert);
}

mysqli_close($conn);
exit();
?>