<?php
// This header assumes session_start() has been called on the page that includes it.
$base_path = '/civiclink-api'; // IMPORTANT: Change if your project folder is different.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Add your site title here -->
    <title>CivicLink</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link to your main stylesheet if you have one -->
    <!-- <link rel="stylesheet" href="<?php echo $base_path; ?>/assets/css/style.css"> -->
    
    <style>
      /* --- HEADER CSS STYLES --- */
      * { margin: 0; padding: 0; box-sizing: border-box; }
      body { font-family: 'Poppins', sans-serif, Helvetica, Arial, sans-serif; }

      .navbar {
          background-color: #fff; padding: 10px 20px; border-bottom: 1px solid #e7e7e7;
          box-shadow: 0 2px 5px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000;
      }
      .nav-container {
          width: 100%; max-width: 1200px; margin: 0 auto; display: flex;
          justify-content: space-between; align-items: center;
      }
      a { text-decoration: none; color: #3e6ba6; }
      .navbar-brand { display: flex; align-items: center; }
      .navbar-brand img { width: 40px; height: 40px; margin-right: 10px; }
      .brand-text { color: #1F2937; font-size: 1.25rem; font-weight: 600; }
      .tagline { font-size: 0.65rem; color: #6B7280; display: block; line-height: 1; }
      .navbar-nav { display: flex; list-style: none; gap: 40px; align-items: center; } /* Centered items vertically */
      .navbar-nav li a { color: #374151; font-size: 1rem; font-weight: 500; padding-bottom: 5px; border-bottom: 2px solid transparent; transition: all 0.2s ease-in-out; }
      .navbar-nav li a:hover, .navbar-nav li a.active { color: #3B82F6; border-bottom: 2px solid #3B82F6; }
      .navbar-right-icons { display: flex; align-items: center; gap: 20px; position: relative; }
      .navbar-right-icons .icon-link { font-size: 1.2rem; color: #6B7280; transition: color 0.2s ease; }
      .navbar-right-icons .icon-link:hover { color: #3B82F6; }

      /* Profile Dropdown Styling */
      .profile-dropdown {
          display: none; position: absolute; top: 50px; right: 0;
          background-color: #fff; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);
          overflow: hidden; min-width: 220px; z-index: 1001; border: 1px solid #e7e7e7;
      }
      .profile-dropdown.active { display: block; }
      .dropdown-header { padding: 15px; border-bottom: 1px solid #e7e7e7; background-color: #F9FAFB; }
      .dropdown-header strong { display: block; color: #1F2937; font-size: 1rem; }
      .dropdown-header span { font-size: 0.85rem; color: #6B7280; }
      .profile-dropdown a.dropdown-item {
          display: flex; align-items: center; gap: 10px; padding: 12px 15px;
          font-size: 0.95rem; color: #374151;
      }
      .profile-dropdown a.dropdown-item:hover { background-color: #F3F4F6; }
      .profile-dropdown a.dropdown-item i { width: 20px; text-align: center; color: #9CA3AF; }
      .dropdown-divider { height: 1px; background-color: #e7e7e7; margin: 5px 0; }
      .dropdown-logout { color: #EF4444 !important; }

      /* Hamburger Menu Styling */
      .menu-toggle { display: none; flex-direction: column; cursor: pointer; }
      .menu-toggle .bar { height: 3px; width: 25px; background-color: #3e6ba6; margin: 4px 0; transition: 0.4s; }

      @media (max-width: 768px) {
          .navbar-nav {
              display: none; flex-direction: column; position: absolute; top: 60px;
              left: 0; width: 100%; background-color: #fff;
              box-shadow: 0 4px 10px rgba(0,0,0,0.08); text-align: center; gap: 0;
          }
          .navbar-nav.active { display: flex; }
          .navbar-nav li { padding: 15px 0; width: 100%; border-bottom: 1px solid #f3f3f3; }
          .navbar-nav li:last-child { border-bottom: none; }
          .navbar-nav li a:hover { border-bottom: none; background-color: #F9FAFB; width: 100%; display: block; }
          .menu-toggle { display: flex; }
          .navbar-right-icons { gap: 15px; }
      }
    </style>
</head>
<body>
  <nav class="navbar">
    <div class="nav-container">
      <a class="navbar-brand" href="<?php echo $base_path; ?>/includes/index.php">
          <img src="<?php echo $base_path; ?>/images/logo_wbg.png" alt="CivicLink Logo">
          <div>
              <span class="brand-text">CivicLink</span>
              <span class="tagline">Connecting Communities</span>
          </div>
      </a>

      <!-- Hamburger Menu Icon for Mobile -->
      <div class="menu-toggle" id="mobile-menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </div>

      <!-- Desktop & Mobile Navigation Links -->
      <ul class="navbar-nav" id="nav-links">
          <li><a href="<?php echo $base_path; ?>/includes/index.php">Home</a></li>
          <li><a href="<?php echo $base_path; ?>/includes/explore.php">Discover</a></li>
          <li><a href="<?php echo $base_path; ?>/includes/report.php">Submit Issue</a></li>
      </ul>

      <!-- Right-side Icons -->
      <div class="navbar-right-icons">
        <!-- <a href="#" class="icon-link" id="search-icon"><i class="fas fa-search"></i></a> -->

        <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
            <!-- USER IS LOGGED IN: Show profile icon with dropdown -->
            <a href="#" class="icon-link" id="profile-icon"><i class="fas fa-user-circle" style="font-size: 1.6rem;"></i></a>
            
            <div class="profile-dropdown" id="profile-dropdown">
                <div class="dropdown-header">
                    <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong>
                    <span>Community Member</span>
                </div>
                <a href="<?php echo $base_path; ?>/includes/profile.php" class="dropdown-item"><i class="fas fa-user"></i> View Profile</a>
                <a href="<?php echo $base_path; ?>/includes/edit_profile.php" class="dropdown-item"><i class="fas fa-edit"></i> Edit Profile</a>
                <a href="<?php echo $base_path; ?>/includes/my_reports.php" class="dropdown-item"><i class="fas fa-flag"></i> My Contributions</a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo $base_path; ?>/handlers/logout_handler.php" class="dropdown-item dropdown-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>

        <?php else: ?>
            <!-- USER IS A GUEST: Show simple login link -->
            <a href="<?php echo $base_path; ?>/includes/login.php" class="icon-link"><i class="fas fa-user"></i></a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- IMPORTANT: Link to the external JavaScript file at the end of the body -->
  <!-- This line should be in your footer.php file to be included on every page -->
  <script src="<?php echo $base_path; ?>/assets/main.js"></script>
</body>
</html>