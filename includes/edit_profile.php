<?php
session_start();
// Security Check: Redirect if not logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php?error=pleaselogin");
    exit;
}

include 'header2.php';
require_once '../config/db_connect.php';

// Get user ID from session and fetch current data
$user_id = $_SESSION['id'];
$sql = "SELECT username, email FROM users WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}
?>

<style>
    .form-container 
    {
         max-width: 600px; 
         margin: 50px auto; 
         padding: 0 20px; 
    }
    .form-card 
    { 
        background-color: #fff; 
        border-radius: 16px;
        width:600px;
        padding: 40px; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.08); 
    }
    .form-card h1
    { 
        font-size: 2rem; 
        font-weight: 700; 
        text-align: center; 
        margin-bottom: 30px; 
    }
    .form-group 
    { 
        margin-bottom: 20px;
    }
    .form-group label
    { 
        display: block; 
        font-weight: 500; 
        margin-bottom: 8px; 
    }
    .form-group input 
    { 
        width: 100%; 
        padding: 12px 15px; 
        border: 1px solid #D1D5DB; 
        border-radius: 8px; font-size: 1rem; 
    }
    .form-actions 
    { 
        margin-top: 30px; 
        display: flex; 
        gap: 15px; 
    }
    .btn 
    {
         padding: 12px 25px; 
         border-radius: 8px; 
         text-decoration: none; 
         font-weight: 500; 
         text-align: center; 
         border: 1px solid transparent; 
         cursor: pointer; 
    }
    .btn-primary
    { 
        background-color: #3B82F6; 
        color: #fff; 
    }
    .btn-secondary 
    {
         background-color: #fff; 
         color: #374151;
         border-color: #D1D5DB; 
    }
    .alert 
    {
         padding: 15px; 
         margin-bottom: 20px; 
         border-radius: 8px; 
    }
    .alert-success 
    { 
        background-color: #D1FAE5; 
        color: #065F46; 
    }
    .alert-danger 
    {
         background-color: #FEE2E2; 
         color: #B91C1C; 
    }
    @media (max-width:760px) {
        .form-card{
             width:200px;
        }
    }
</style>

<div class="form-container">
    <div class="form-card">
        <h1>Edit Your Profile</h1>

        <?php 
        // Display any success or error messages passed in the URL
        if (!empty($_GET['status']) && $_GET['status'] == 'success') {
            echo '<div class="alert alert-success">Profile updated successfully!</div>';
        }
        if (!empty($_GET['error'])) {
            echo '<div class="alert alert-danger">' . htmlspecialchars(urldecode($_GET['error'])) . '</div>';
        }
        ?>

        <form action="../handlers/edit_profile_handler.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">New Password (optional)</label>
                <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="profile.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>