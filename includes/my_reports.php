<?php
session_start();
// Security Check: If the user is not logged in, redirect them to the login page.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php?error=pleaselogin");
    exit;
}

// Include header and database connection
include 'header2.php';
require_once '../config/db_connect.php';

// Get the logged-in user's ID from the session
$current_user_id = $_SESSION['id'];

// --- DATA FETCHING LOGIC ---
// Fetch issues WHERE the user_id matches the logged-in user's ID
$sql = "SELECT * FROM issues WHERE user_id = ? ORDER BY created_at DESC";
$issues = [];

if ($stmt = mysqli_prepare($conn, $sql)) {
    // Bind the user's ID as a parameter to the prepared statement for security
    mysqli_stmt_bind_param($stmt, "i", $current_user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $issues = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);

// Helper function for status badge styling
function getStatusClass($status) {
    switch (strtolower($status)) {
        case 'under review': return 'status-review';
        case 'resolved': return 'status-resolved';
        default: return 'status-open';
    }
}
?>

<!-- Internal CSS for consistency with the explore page -->
<style>
    :root {
        --primary-blue: #3B82F6; --light-gray-bg: #F9FAFB; --border-color: #E5E7EB;
        --text-color-light: #6B7280; --text-color-dark: #1F2937;
        --status-open-bg: #DBEAFE; --status-open-text: #1E40AF;
        --status-review-bg: #FEF3C7; --status-review-text: #92400E;
        --status-resolved-bg: #D1FAE5; --status-resolved-text: #065F46;
    }
    .page-container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
    .page-header { margin-bottom: 30px; }
    .page-header h1 { font-size: 2.5rem; font-weight: 700; color: var(--text-color-dark); }
    .page-header p { font-size: 1.1rem; color: var(--text-color-light); }
    
    .issue-card { display: flex; gap: 20px; background-color: #fff; padding: 20px; border-radius: 16px; border: 1px solid var(--border-color); margin-bottom: 20px; }
    .issue-card-img { width: 100px; height: 100px; border-radius: 12px; object-fit: cover; background-color: var(--light-gray-bg); }
    .issue-card-content { flex-grow: 1; }
    .card-top-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
    .card-title { font-size: 1.2rem; font-weight: 600; color: var(--text-color-dark); margin-bottom: 0; }
    .card-status { font-size: 0.8rem; font-weight: 600; padding: 4px 12px; border-radius: 20px; }
    .status-open { background-color: var(--status-open-bg); color: var(--status-open-text); }
    .status-review { background-color: var(--status-review-bg); color: var(--status-review-text); }
    .status-resolved { background-color: var(--status-resolved-bg); color: var(--status-resolved-text); }
    .card-description { color: var(--text-color-light); margin-bottom: 15px; font-size: 0.95rem; }
    .card-date { font-size: 0.85rem; color: var(--text-color-light); }
</style>

<div class="page-container">
    <div class="page-header">
        <h1>My Contributions</h1>
        <p>A list of all the civic issues you have reported.</p>
    </div>

    <div class="issues-list">
        <?php if (empty($issues)): ?>
            <div class="alert alert-info text-center">You haven't reported any issues yet. <a href="report.php">Report one now!</a></div>
        <?php else: ?>
            <?php foreach ($issues as $issue): ?>
                <div class="issue-card">
                    <?php 
                        $base_path = '/civiclink-api';
                        $imageSrc = !empty($issue['photo_path']) ? $base_path . '/' . htmlspecialchars($issue['photo_path']) : $base_path . '/assets/images/default-placeholder.png';
                    ?>
                    <img src="<?php echo $imageSrc; ?>" alt="Issue Image" class="issue-card-img">
                    <div class="issue-card-content">
                        <div class="card-top-row">
                            <h3 class="card-title"><?php echo htmlspecialchars($issue['title']); ?></h3>
                            <span class="card-status <?php echo getStatusClass($issue['status']); ?>"><?php echo htmlspecialchars(ucfirst($issue['status'])); ?></span>
                        </div>
                        <p class="card-description"><?php echo htmlspecialchars($issue['description']); ?></p>
                        <p class="card-date">Reported on: <?php echo date('F j, Y', strtotime($issue['created_at'])); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>