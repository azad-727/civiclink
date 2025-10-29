<?php
session_start();
// Security Check: Redirect if not logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php?error=pleaselogin");
    exit;
}

include 'header2.php';
require_once '../config/db_connect.php';

// Get user ID from session
$user_id = $_SESSION['id'];
$user = null;

// --- DATA FETCHING LOGIC ---
// Fetch user data from the 'users' table
$sql = "SELECT username, email, created_at FROM users WHERE id = ?";

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>

<style>
    .profile-container { max-width: 800px; margin: 50px auto; padding: 0 20px; }
    .profile-card {
        background-color: #fff;
        border-radius: 16px;
        width:800px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid #E5E7EB;
    }
    .profile-header { display: flex; align-items: center; gap: 25px; margin-bottom: 30px; }
    .profile-avatar {
        width: 100px; height: 100px; border-radius: 50%; background-color: #DBEAFE;
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem; font-weight: 600; color: #3B82F6; flex-shrink: 0;
    }
    .profile-header h1 { font-size: 2.2rem; font-weight: 700; color: #1F2937; margin: 0; }
    .profile-header p { font-size: 1rem; color: #6B7280; margin: 0; }

    .profile-details dl { display: grid; grid-template-columns: max-content 1fr; gap: 15px 20px; }
    .profile-details dt { font-weight: 500; color: #6B7280; } /* Term (e.g., "Username") */
    .profile-details dd { font-weight: 500; color: #1F2937; } /* Description (e.g., "Azad") */

    .profile-actions { margin-top: 30px; border-top: 1px solid #E5E7EB; padding-top: 30px; text-align: right; }
    .btn-edit-profile {
        background-color: #3B82F6; color: #fff; padding: 12px 25px;
        border-radius: 8px; text-decoration: none; font-weight: 500;
        transition: background-color 0.2s ease;
    }
    .btn-edit-profile:hover { background-color: #2563EB; }
    @media (max-width: 768px) {
    .profile-card {
        width:200px;
    }
    }
</style>

<div class="profile-container">
    <div class="profile-card">
        <?php if ($user): ?>
            <div class="profile-header">
                <div class="profile-avatar">
                    <?php echo htmlspecialchars(strtoupper(substr($user['username'], 0, 1))); ?>
                </div>
                <div>
                    <h1><?php echo htmlspecialchars($user['username']); ?></h1>
                    <p>Community Member</p>
                </div>
            </div>

            <div class="profile-details">
                <dt>Username</dt>
                <dd><?php echo htmlspecialchars($user['username']); ?></dd>
                
                <dt>Email Address</dt>
                <dd><?php echo htmlspecialchars($user['email']); ?></dd>

                <dt>Member Since</dt>
                <dd><?php echo date('F j, Y', strtotime($user['created_at'])); ?></dd>
            </div>

            <div class="profile-actions">
                <a href="edit_profile.php" class="btn-edit-profile">Edit Profile</a>
            </div>
        <?php else: ?>
            <p>Could not retrieve user profile.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>