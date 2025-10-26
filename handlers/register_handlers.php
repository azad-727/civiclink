<?php

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Sanitize and retrieve form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']); 
    // 2. Validate the data
    $errors = [];
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // 3. Check if email already exists in the database
    if (empty($errors)) {
        $sql_check = "SELECT id FROM users WHERE email = ?";
        
        if ($stmt_check = mysqli_prepare($link, $sql_check)) {
            mysqli_stmt_bind_param($stmt_check, "s", $email);
            mysqli_stmt_execute($stmt_check);
            mysqli_stmt_store_result($stmt_check);
            
            if (mysqli_stmt_num_rows($stmt_check) > 0) {
                $errors[] = "An account with this email already exists.";
            }
            mysqli_stmt_close($stmt_check);
        }
    }

    // 4. If there are no errors, insert the new user into the database
    if (empty($errors)) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql_insert = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        
        if ($stmt_insert = mysqli_prepare($link, $sql_insert)) {
            mysqli_stmt_bind_param($stmt_insert, "sss", $username, $email, $hashed_password);
            
            if (mysqli_stmt_execute($stmt_insert)) {
                // Registration successful, redirect to login page with a success message
                header("location: ../login.php?status=success");
                exit();
            } else {
                // If insertion fails, it's a server error
                header("location: ../register.php?error=Something went wrong. Please try again later.");
                exit();
            }
            mysqli_stmt_close($stmt_insert);
        }
    } else {
        // If there are validation errors, redirect back to the registration page
        // Encode the errors array to be passed as a URL parameter
        $error_string = urlencode(implode("<br>", $errors));
        header("location: ../register.php?error=" . $error_string);
        exit();
    }

    // Close the database connection
    mysqli_close($link);
} else {
    // If someone tries to access this file directly, redirect them
    header("location: ../register.php");
    exit();
}
?>C:\xampp\htdocs\civiclink-api\handlers\register_handlers.php