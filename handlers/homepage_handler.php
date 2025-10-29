<?php
// Set the correct header to indicate the response is JSON
header('Content-Type: application/json');
// Include your database connection script
require_once '../config/db_connect.php';

// SQL query to fetch the 5 most recent issues.
// We join with the 'users' table to get the reporter's username.
$sql = "SELECT 
            i.title, 
            i.location_lat, 
            i.location_lng, 
            i.photo_path, 
            i.created_at, 
            i.status, 
            i.category, 
            u.username 
        FROM issues i 
        JOIN users u ON i.user_id = u.id 
        ORDER BY i.created_at DESC 
        LIMIT 5";

$result = mysqli_query($conn, $sql);
$issues = [];
if ($result) {
    // Fetch all results into an associative array
    $issues = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Close the database connection
mysqli_close($conn);

// Encode the PHP array into a JSON string and send it as the response
echo json_encode($issues);
?>