<?php
// Set the content type to JSON
header('Content-Type: application/json');
require_once '../config/db_connect.php';

// Fetch the 5 most recent issues. We also join to get the username.
$sql = "SELECT i.*, u.username 
        FROM issues i 
        JOIN users u ON i.user_id = u.id 
        ORDER BY i.created_at DESC 
        LIMIT 5";

$result = mysqli_query($link, $sql);
$issues = [];
if ($result) {
    $issues = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

mysqli_close($link);

// Output the final result as a JSON object
echo json_encode($issues);
?>