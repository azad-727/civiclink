<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CivicLink</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
      /* --- CSS STYLES --- */
      * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
      }

      body {
          font-family: Helvetica, Arial, sans-serif;
      }

      .navbar {
          background-color: #fbfbfb;
          padding: 10px 20px;
          border-bottom: 1px solid #e7e7e7;
          box-shadow: 0px 2px 4px rgba(0,0,0,0.1);
          position: sticky;
          top: 0;
          z-index: 1000;
      }

      .nav-container {
          width: 100%;
          max-width: 1200px;
          margin: 0 auto;
          display: flex;
          justify-content: space-between;
          align-items: center;
      }

      a {
          text-decoration: none;
          color: #3e6ba6;
      }

      .navbar-brand {
          display: flex;
          align-items: center;
      }

      .navbar-brand img {
          width: 40px;
          height: 40px;
          margin-right: 10px;
      }

      .brand-text {
          color: #3e6ba6;
          font-size: 1.25rem;
          font-weight: 520;
      }

      .tagline {
          font-size: 0.65rem;
          color: #3e6ba6;
          display: block;
          line-height: 1;
      }

      .navbar-nav {
          display: flex;
          list-style: none;
          gap: 40px;
      }

      .navbar-nav li a {
          font-size: 1.05rem;
          font-weight: 520;
          padding-bottom: 5px;
          transition: border-bottom 0.2s ease-in-out;
      }

      .navbar-nav li a:hover {
          border-bottom: 2px solid #0d6efd;
      }

      .navbar-right-icons {
          display: flex;
          align-items: center;
          gap: 20px;
      }

      .navbar-right-icons .fas {
          font-size: 1.2rem;
          color: #3e6ba6;
      }

      #search-input {
          display: none; /* Hidden by default */
          border: 1px solid #ccc;
          border-radius: 5px;
          padding: 5px;
      }

      /* Hamburger Menu Styling */
      .menu-toggle {
          display: none; /* Hidden on desktop */
          flex-direction: column;
          cursor: pointer;
      }

      .menu-toggle .bar {
          height: 3px;
          width: 25px;
          background-color: #3e6ba6;
          margin: 4px 0;
          transition: 0.4s;
      }

      /* Mobile Responsiveness */
      @media (max-width: 768px) {
          .navbar-nav {
              display: none; /* Hide nav links */
              flex-direction: column;
              position: absolute;
              top: 60px; /* Position below the navbar */
              left: 0;
              width: 100%;
              background-color: #fbfbfb;
              box-shadow: 0px 2px 4px rgba(0,0,0,0.1);
              text-align: center;
              gap: 0;
          }

          .navbar-nav.active {
              display: flex; /* Show nav links when active */
          }

          .navbar-nav li {
              padding: 15px 0;
              width: 100%;
          }

          .navbar-nav li a:hover {
              border-bottom: none;
              background-color: #ebf0f0;
              width: 100%;
              display: block;
          }

          .menu-toggle {
              display: flex; /* Show hamburger menu */
          }

          .nav-container {
              justify-content: space-between;
          }
      }
    </style>
</head>
<body>
  <nav class="navbar">
    <div class="nav-container">
      <a class="navbar-brand" href="#">
          <img src="../images/logo_wbg.png" alt="CivicLink Logo">
          <div>
              <span class="brand-text">CivicLink</span>
              <span class="tagline">Connecting Communities, Solving Issues</span>
          </div>
      </a>

      <!-- Hamburger Menu Icon -->
      <div class="menu-toggle" id="mobile-menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </div>

      <!-- Desktop Navigation Links -->
      <ul class="navbar-nav">
          <li><a href="#">Home</a></li>
          <li><a href="#">Discover</a></li>
          <li><a href="#">Submit</a></li>
      </ul>

      <!-- Right-side Icons -->
      <div class="navbar-right-icons">
        <a href="#" id="search-icon"><i class="fas fa-search"></i></a>
        <input type="search" name="search" id="search-input" placeholder="Search...">
        <a href="#" class="profile-icon-circle"><i class="fas fa-user"></i></a>
      </div>
    </div>
  </nav>

  <script>
    // --- JAVASCRIPT CODE ---
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        const navLinks = document.querySelector('.navbar-nav');
        const searchIcon = document.getElementById('search-icon');
        const searchInput = document.getElementById('search-input');

        // Toggle mobile navigation
        mobileMenu.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Toggle search bar visibility
        searchIcon.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent the link from navigating

            // Toggle the display of the search input
            if (searchInput.style.display === 'block') {
                searchInput.style.display = 'none';
            } else {
                searchInput.style.display = 'block';
            }
        });
    });
  </script>
</body>
</html>