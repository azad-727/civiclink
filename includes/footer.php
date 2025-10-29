<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page with Responsive Footer</title>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Basic body reset and styling */
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Ensures footer stays at the bottom */
        }

        /* Main content area to push footer down */
        .main-content {
            flex: 1;
            padding: 20px; /* Example padding */
        }

        /*
        =================================
        FOOTER STYLES
        =================================
        */
        .site-footer {
            background-color: #ffffff;
            color: #6c757d; /* Muted text color */
            padding: 40px 0;
            border-top: 1px solid #e7e7e7;
            font-size: 15px;
        }

        .footer-container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-top {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap; /* Allows columns to wrap on smaller screens */
            gap: 30px; /* Space between columns */
        }

        .footer-column {
            flex: 1;
            min-width: 200px; /* Prevents columns from getting too narrow before wrapping */
        }

        /* Footer Logo and Tagline */
        .footer-brand img {
            height: 40px;
            margin-bottom: 10px;
        }
        
        .footer-brand h4 {
            margin-bottom: 10px;
        }

        .footer-brand .tagline {
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Footer Headings */
        .footer-column h4 {
            color: #333;
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 15px;
            text-transform: uppercase; /* Makes headings stand out */
            letter-spacing: 0.5px;
        }

        /* Footer Links */
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            text-decoration: none;
            color: #6c757d;
            transition: color 0.2s ease-in-out;
        }

        .footer-links a:hover {
            color: #0d6efd; /* Brand blue color on hover */
        }

        /* Footer Bottom Section */
        .footer-bottom {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e7e7e7;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .copyright-text {
            font-size: 0.9rem;
        }

        .social-icons a {
            color: #6c757d;
            font-size: 1.2rem;
            margin-left: 18px;
            text-decoration: none;
            transition: color 0.2s ease-in-out;
        }

        .social-icons a:hover {
            color: #0d6efd; /* Brand blue color on hover */
        }
        
        /* 
        =================================
        RESPONSIVE ADJUSTMENTS
        =================================
        */
        @media (max-width: 768px) {
            /* Stack footer columns vertically on mobile */
            .footer-top {
                flex-direction: column;
                gap: 20px; /* Adjust gap for vertical stacking */
            }

            /* Left-align text for better readability in a single column */
            .footer-column {
                text-align: left;
            }
            
            .footer-column h4 {
                text-align: left;
            }

            .footer-links {
                text-align: left;
            }

            /* Center the bottom section content */
            .footer-bottom {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .social-icons {
                margin-top: 15px;
            }

            .social-icons a {
                margin: 0 12px; /* Adjust spacing for social icons */
            }
        }

    </style>
</head>
<body>



    <!-- =================== FOOTER START =================== -->
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-top">
                
                <!-- Column 1: Brand Info -->
                <div class="footer-column footer-brand">
                    <img src="../images/logo_wbg.png" alt="CivicLink Logo">
                    <h4>CivicLink</h4>
                    <p class="tagline">Connecting communities and empowering citizens to solve local issues together.</p>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="footer-column">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Discover Issues</a></li>
                        <li><a href="report.php">Submit an Issue</a></li>
                        <li><a href="#">How It Works</a></li>
                    </ul>
                </div>

                <!-- Column 3: About -->
                <div class="footer-column">
                    <h4>About</h4>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">FAQs</a></li>
                    </ul>
                </div>

                <!-- Column 4: Legal -->
                <div class="footer-column">
                    <h4>Legal</h4>
                    <ul class="footer-links">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>

            </div>

            <div class="footer-bottom">
                <div class="copyright-text">
                    &copy; 2025 CivicLink. All Rights Reserved.
                </div>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <!-- =================== FOOTER END =================== -->
<?php

?>
    <script src="<?php echo $base_path; ?>/assets/js/main.js"></script>

</body>
</html>