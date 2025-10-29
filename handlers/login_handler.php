<?php
// Always start the session at the very beginning
session_start();

// Include the database connection file
require_once '../config/db_connect.php';

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Sanitize and retrieve form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $errors = [];

    // 2. Validate input
    if (empty($email)) {
        $errors[] = "Email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // 3. If there are no validation errors, proceed to check credentials
    if (empty($errors)) {
        // Prepare a select statement to find the user by email
        $sql = "SELECT id, username, email, password FROM users WHERE email = ?";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                
                // Check if a user with that email exists
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $db_email, $hashed_password);
                    
                    if (mysqli_stmt_fetch($stmt)) {
                        // 4. Verify the password
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to a welcome page (e.g., the explore page)
                            header("location: ../explore.php");
                            exit();
                        } else {
                            // Password is not valid
                            $errors[] = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // No account found with that email
                    $errors[] = "No account found with that email address.";
                }
            } else {
                $errors[] = "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // If there were any errors, redirect back to the login page
    if (!empty($errors)) {
        $error_string = urlencode(implode("<br>", $errors));
        header("location: ../includes/login.php?error=" . $error_string);
        exit();
    }
    
    // Close connection
    mysqli_close($conn);
} else {
    // If someone tries to access this file directly, redirect them
    header("location: ../includes/login.php");
    exit();
}
?>