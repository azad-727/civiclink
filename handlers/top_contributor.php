<?php
header('Content-Type: application/json');
require_once '../config/db_connect.php';

// SQL query to get top contributors by counting their reports.
$sql = "SELECT 
            u.username,
            COUNT(i.id) AS report_count
        FROM issues i
        JOIN users u ON i.user_id = u.id
        GROUP BY u.username /* Group by username to count reports per user */
        ORDER BY report_count DESC /* Order from highest to lowest count */
        LIMIT 5"; /* Get only the top 5 */

$result = mysqli_query($conn, $sql);
$contributors = [];
if ($result) {
    $contributors = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

mysqli_close($conn);

echo json_encode($contributors);
?>