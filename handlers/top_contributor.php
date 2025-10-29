<?php
header('Content-Type: application/json');
require_once '../config/db_connect.php';

// SQL query to get top contributors
// 1. COUNT issues for each user_id and name the count 'report_count'.
// 2. JOIN with the 'users' table to get the 'username'.
// 3. GROUP BY user_id to make the COUNT work correctly.
// 4. ORDER BY the count in descending order.
// 5. LIMIT to the top 5 results.
$sql = "SELECT 
            u.username,
            COUNT(i.id) AS report_count
        FROM 
            issues i
        JOIN 
            users u ON i.user_id = u.id
        GROUP BY 
            i.user_id
        ORDER BY 
            report_count DESC
        LIMIT 5";

$result = mysqli_query($link, $sql);
$contributors = [];
if ($result) {
    $contributors = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

mysqli_close($link);

echo json_encode($contributors);
?>