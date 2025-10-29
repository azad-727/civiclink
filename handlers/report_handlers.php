<?php
session_start();
require_once '../config/db_connect.php';

// Security Check 1: Is the user logged in?
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php?error=pleaselogin");
    exit;
}

// Security Check 2: Was the form submitted via POST?
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Sanitize and retrieve form data
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $lat = trim($_POST['lat']);
    $lng = trim($_POST['lng']);
    $user_id = $_SESSION['id'];
    $photoPath = null; // Photo is optional, so default to null
    $errors = [];

    // 2. Validate essential form data
    if (empty($title) || empty($description) || empty($category) || empty($lat) || empty($lng)) {
        $errors[] = "Title, description, category, and map location are required.";
    }

    // 3. Handle the optional file upload securely
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "../uploads/"; // Assumes an 'uploads' folder in your project root
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

        $fileInfo = pathinfo($_FILES['photo']['name']);
        $fileExtension = strtolower($fileInfo['extension']);
        $uniqueName = uniqid('img_', true) . '.' . $fileExtension;
        $targetFile = $targetDir . $uniqueName;
        
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileExtension, $allowedTypes)) {
            $errors[] = "Invalid file type. Only JPG, JPEG, PNG, GIF are allowed.";
        } elseif ($_FILES['photo']['size'] > 5000000) { // 5MB limit
            $errors[] = "File is too large. Maximum size is 5MB.";
        } else {
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                $photoPath = "uploads/" . $uniqueName;
            } else {
                $errors[] = "Failed to upload photo.";
            }
        }
    }

    // 4. If there are no errors, insert into the database
    if (empty($errors)) {
        $sql = "INSERT INTO issues (user_id, title, description, category, location_lat, location_lng, photo_path) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "isssdds", $user_id, $title, $description, $category, $lat, $lng, $photoPath);
            
            if (mysqli_stmt_execute($stmt)) {
                header("location: ../includes/explore.php?status=reported");
                exit();
            } else {
                $errors[] = "Database error. Please try again.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    
    $error_string = urlencode(implode("<br>", $errors));
    header("location: ../report.php?error=" . $error_string);
    exit();
}
?>