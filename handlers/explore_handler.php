<?php
// Set the content type header to JSON, which is crucial for the frontend JavaScript
header('Content-Type: application/json');

// We don't need a session here unless we want to filter by user-specific things,
// but for a public explore page, it's not required. We do need the DB connection.
require_once '../config/db_connect.php';

// --- DATA FETCHING LOGIC ---

// 1. Check if latitude and longitude are provided in the URL query string
$userLat = isset($_GET['lat']) ? (float)$_GET['lat'] : null;
$userLng = isset($_GET['lng']) ? (float)$_GET['lng'] : null;
$issues = [];

// 2. Define the Haversine formula for distance calculation in SQL.
// 6371 is the Earth's radius in kilometers.
$distance_formula = " ( 6371 * acos( cos( radians(?) ) * cos( radians( location_lat ) ) * cos( radians( location_lng ) - radians(?) ) + sin( radians(?) ) * sin( radians( location_lat ) ) ) ) ";

// 3. Decide which SQL query to run based on whether we have the user's location
if ($userLat && $userLng) {
    // ---- QUERY 1: LOCATION-AWARE ----
    // This query fetches ALL issues but calculates the distance for each.
    // It then sorts them in a special way:
    //  - First, it groups issues into "nearby" (< 50km) and "far" (> 50km).
    //  - Then, it sorts by the actual distance within each group.
    
    $sql = "SELECT i.*, u.username, " . $distance_formula . " AS distance 
            FROM issues i 
            JOIN users u ON i.user_id = u.id 
            ORDER BY 
                CASE 
                    WHEN distance < 50 THEN 0 
                    ELSE 1 
                END, 
                distance ASC";
    
    // Use a prepared statement for security
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind the user's lat/lng to the three '?' placeholders in the formula
        mysqli_stmt_bind_param($stmt, "ddd", $userLat, $userLng, $userLat);
        
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $issues = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
    }

} else {
    // ---- QUERY 2: DEFAULT (NO LOCATION) ----
    // This is the fallback query. If the user denies location access or the
    // browser doesn't support it, we just show the most recently reported issues.
    
    $sql = "SELECT i.*, u.username 
            FROM issues i 
            JOIN users u ON i.user_id = u.id 
            ORDER BY i.created_at DESC";
            
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $issues = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

// Close the database connection as we are done with it.
mysqli_close($conn);

// 4. Output the final result as a JSON string.
// The frontend JavaScript will fetch and parse this string.
echo json_encode($issues);
?>