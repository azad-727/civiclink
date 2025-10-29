// In issue_detail.php
<?
// ... after fetching data ...
$issue = mysqli_fetch_assoc($result);

// If no issue was found with that ID
if (!$issue) {
    // Redirect to a custom 404 page or show a clean error message
    header("HTTP/1.0 404 Not Found");
    include '404.php'; // You'll create this simple page
    exit();
}
?>