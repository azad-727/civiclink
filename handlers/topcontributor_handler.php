<?php
header('Content-Type: application/json');
require_once '../config/db_connect.php';

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

$result = mysqli_query($conn, $sql);
$contributors = [];
if ($result) {
    $contributors = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

mysqli_close($conn);

echo json_encode($contributors);
?>
