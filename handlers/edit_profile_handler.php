<?php
session_start();
require_once '../config/db_connect.php';

// Security Check: Redirect if not logged in or form not submitted via POST
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SERVER["REQUEST_METHOD"] != "POST") {
    header("location: ../includes/login.php");
    exit;
}

// Get user ID and form data
$user_id = $_SESSION['id'];
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$errors = [];

// --- VALIDATION ---
if (empty($username) || empty($email)) {
    $errors[] = "Username and email cannot be empty.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}
// Check if the new email is already taken by ANOTHER user
$sql_check_email = "SELECT id FROM users WHERE email = ? AND id != ?";
if ($stmt_check = mysqli_prepare($conn, $sql_check_email)) {
    mysqli_stmt_bind_param($stmt_check, "si", $email, $user_id);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);
    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        $errors[] = "This email address is already in use by another account.";
    }
    mysqli_stmt_close($stmt_check);
}

// --- DATABASE UPDATE ---
if (empty($errors)) {
    // Check if a new password was provided
    if (!empty($password)) {
        // A new password was entered, so we update it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql_update = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
        if ($stmt_update = mysqli_prepare($conn, $sql_update)) {
            mysqli_stmt_bind_param($stmt_update, "sssi", $username, $email, $hashed_password, $user_id);
        }
    } else {
        // No new password, so we only update username and email
        $sql_update = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        if ($stmt_update = mysqli_prepare($conn, $sql_update)) {
            mysqli_stmt_bind_param($stmt_update, "ssi", $username, $email, $user_id);
        }
    }

    if (mysqli_stmt_execute($stmt_update)) {
        // Success! Update the session variable with the new username
        $_SESSION['username'] = $username;
        // Redirect back to the edit page with a success message
        header("location: ../includes/edit_profile.php?status=success");
        exit();
    } else {
        $errors[] = "Something went wrong. Please try again.";
    }
    mysqli_stmt_close($stmt_update);
}

// If there were any errors, redirect back with the error messages
if (!empty($errors)) {
    $error_string = urlencode(implode("<br>", $errors));
    header("location: ../includes/edit_profile.php?error=" . $error_string);
    exit();
}
?>