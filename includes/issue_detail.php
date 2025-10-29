<?php

session_start();
// This page is public, but we need the session to know if the user can verify.
$is_logged_in = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;

include 'header2.php';
require_once '../config/db_connect.php';

// Get the issue ID from the URL, make sure it's an integer.
$issue_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($issue_id <= 0) {
    echo "<p>Invalid issue ID.</p>";
    include 'footer.php';
    exit;
}

// --- DATA FETCHING ---
// Fetch issue details AND the reporter's username using a JOIN.
$sql = "SELECT i.*, u.username 
        FROM issues i 
        JOIN users u ON i.user_id = u.id 
        WHERE i.id = ?";
$issue = null;

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $issue_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $issue = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// Check if this specific user has already verified this issue.
$user_has_verified = false;
if ($is_logged_in) {
    $user_id = $_SESSION['id'];
    $sql_check = "SELECT id FROM verifications WHERE user_id = ? AND issue_id = ?";
    if ($stmt_check = mysqli_prepare($conn, $sql_check)) {
        mysqli_stmt_bind_param($stmt_check, "ii", $user_id, $issue_id);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $user_has_verified = true;
        }
        mysqli_stmt_close($stmt_check);
    }
}
mysqli_close($conn);
?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<style>
    /* --- CSS FOR ISSUE DETAIL PAGE --- */
    :root {
        --primary-blue: #3B82F6; --light-gray-bg: #F9FAFB; --border-color: #E5E7EB;
        --text-color-light: #6B7280; --text-color-dark: #1F2937;
    }
    body { background-color: var(--light-gray-bg); }
    .page-container { max-width: 1100px; margin: 50px auto; padding: 0 20px; }
    
    /* Desktop Layout: Two Columns */
    .detail-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 40px; }
    .main-content {}
    .sidebar { position: sticky; top: 100px; /* Adjust based on your header height */ }
    
    .issue-title { font-size: 2.8rem; font-weight: 700; color: var(--text-color-dark); margin-bottom: 30px; line-height: 1.2; }
    
    /* Image Gallery */
    .image-gallery { margin-bottom: 30px; }
    .main-image { width: 100%; height: 400px; border-radius: 16px; object-fit: cover; background-color: var(--border-color); }
    .thumbnail-track { display: flex; gap: 10px; margin-top: 10px; }
    .thumbnail { width: 80px; height: 60px; border-radius: 8px; object-fit: cover; cursor: pointer; border: 2px solid transparent; opacity: 0.6; }
    .thumbnail.active { border-color: var(--primary-blue); opacity: 1; }

    /* Description */
    .description-section h3 { font-size: 1.5rem; font-weight: 600; margin-bottom: 15px; }
    .description-section p { font-size: 1rem; color: var(--text-color-light); line-height: 1.7; }

    /* Sidebar */
    .sidebar-card { background-color: #fff; border-radius: 16px; padding: 25px; border: 1px solid var(--border-color); }
    #detailMap { height: 200px; width: 100%; border-radius: 12px; margin-bottom: 20px; z-index: 1; }
    
    /* Verify Button */
    .verify-button {
        display: flex; align-items: center; justify-content: center; width: 100%; padding: 15px;
        border: none; border-radius: 8px; background-color: var(--primary-blue); color: #fff;
        font-size: 1rem; font-weight: 600; cursor: pointer; transition: background-color 0.2s ease;
    }
    .verify-button.disabled { background-color: #9CA3AF; cursor: not-allowed; }
    .verify-button:not(.disabled):hover { background-color: #2563EB; }
    .verify-button .count { background-color: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 20px; margin-left: 10px; }
    
    /* Meta Info */
    .meta-info { margin-top: 25px; font-size: 0.9rem; }
    .meta-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--border-color); }
    .meta-item:last-child { border-bottom: none; }
    .meta-item dt { color: var(--text-color-light); }
    .meta-item dd { color: var(--text-color-dark); font-weight: 500; display: flex; align-items: center; gap: 8px; }
    .reporter-avatar { width: 24px; height: 24px; border-radius: 50%; background-color: #EFF6FF; color: var(--primary-blue); display: inline-flex; align-items: center; justify-content: center; font-weight: 600; }
    .alert-msg { padding: 10px; text-align: center; border-radius: 8px; margin-top: 15px; font-size: 0.9rem; }
    .alert-success { background-color: #D1FAE5; color: #065F46; }
    .alert-info { background-color: #DBEAFE; color: #1E40AF; }

    /* Mobile Responsive Styles */
    @media (max-width: 992px) {
        .detail-layout { grid-template-columns: 1fr; }
        .sidebar { position: static; margin-top: 40px; }
        .issue-title { font-size: 2.2rem; }
        .main-image { height: 300px; }
    }
</style>

<div class="page-container">
    <?php if ($issue): ?>
        <div class="detail-layout">
            <!-- Main Content (Left Column on Desktop) -->
            <div class="main-content">
                <h1 class="issue-title"><?php echo htmlspecialchars($issue['title']); ?></h1>
                
                <div class="image-gallery">
                    <?php 
                        $base_path = '/civiclink-api';
                        $imageSrc = !empty($issue['photo_path']) ? $base_path . '/' . htmlspecialchars($issue['photo_path']) : $base_path . '/assets/images/default-placeholder.png';
                    ?>
                    <img src="<?php echo $imageSrc; ?>" alt="Main issue image" class="main-image">
                    <!-- Thumbnail track can be added here if you support multiple images -->
                </div>

                <div class="description-section">
                    <h3>Description</h3>
                    <p><?php echo nl2br(htmlspecialchars($issue['description'])); ?></p>
                </div>
            </div>

            <!-- Sidebar (Right Column on Desktop) -->
            <div class="sidebar">
                <div class="sidebar-card">
                    <div id="detailMap"></div>

                    <form action="../handlers/verify_handler.php" method="POST">
                        <input type="hidden" name="issue_id" value="<?php echo $issue['id']; ?>">
                        <?php if (!$is_logged_in): ?>
                            <a href="login.php" class="verify-button">Login to Verify <span class="count"><?php echo $issue['verify_count']; ?></span></a>
                        <?php elseif ($user_has_verified): ?>
                            <button type="button" class="verify-button disabled">Verified <span class="count"><?php echo $issue['verify_count']; ?></span></button>
                        <?php else: ?>
                            <button type="submit" class="verify-button">Verify Issue <span class="count"><?php echo $issue['verify_count']; ?></span></button>
                        <?php endif; ?>
                    </form>

                    <?php
                    // Display success/info messages
                    if (isset($_GET['status']) && $_GET['status'] == 'verified') {
                        echo '<div class="alert-msg alert-success">Thank you for verifying!</div>';
                    }
                    if (isset($_GET['status']) && $_GET['status'] == 'already_verified') {
                        echo '<div class="alert-msg alert-info">You have already verified this issue.</div>';
                    }
                    ?>
                    
                    <div class="meta-info">
                        <dl>
                            <div class="meta-item">
                                <dt>Submitted By</dt>
                                <dd>
                                    <div class="reporter-avatar"><?php echo strtoupper(substr($issue['username'], 0, 1)); ?></div>
                                    <?php echo htmlspecialchars($issue['username']); ?>
                                </dd>
                            </div>
                            <div class="meta-item">
                                <dt>Submitted On</dt>
                                <dd><?php echo date('M d, Y', strtotime($issue['created_at'])); ?></dd>
                            </div>
                            <div class="meta-item">
                                <dt>Category</dt>
                                <dd><?php echo htmlspecialchars($issue['category']); ?></dd>
                            </div>
                            <div class="meta-item">
                                <dt>Status</dt>
                                <dd><?php echo htmlspecialchars(ucfirst($issue['status'])); ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <h1 class="text-center">Issue Not Found</h1>
        <p class="text-center">The issue you are looking for does not exist or has been removed.</p>
    <?php endif; ?>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if ($issue): ?>
        // Initialize the map only if the issue exists
        const lat = <?php echo $issue['location_lat']; ?>;
        const lng = <?php echo $issue['location_lng']; ?>;

        const map = L.map('detailMap', {
            zoomControl: false,
            scrollWheelZoom: false
        }).setView([lat, lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        L.marker([lat, lng]).addTo(map);
    <?php endif; ?>
});
</script>

<?php include 'footer.php'; ?>