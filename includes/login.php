<?php
// Always start the session at the very beginning of the file
session_start();

// If the user is already logged in, redirect them away from the login page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: explore.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - CivicLink</title>
    
    <!-- Google Fonts for a modern, clean look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- Universal Styles & Variables --- */
        :root {
            --primary-blue: #4A89DC; /* As seen in the "Sign In" button */
            --light-gray-bg: #f4f6f8; /* The subtle background color */
            --border-color: #e0e4e8;
            --text-color-light: #6c757d;
            --text-color-dark: #333;
            --alert-danger-bg: #f8d7da;
            --alert-danger-text: #721c24;
            --alert-success-bg: #d4edda;
            --alert-success-text: #155724;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-gray-bg);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px; /* Ensures space on all screen sizes */
        }

        /* --- Main Container for the Login Panel --- */
        .login-container {
            display: flex;
            flex-direction: column; /* Mobile-first: stacks vertically */
            width: 100%;
            max-width: 950px; /* Max width for desktop view */
            background-color: #fff;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border-radius: 16px; /* Rounded corners for the desktop view */
        }

        /* --- Branding Section --- */
        .branding-section {
            padding: 40px;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Pushes content to top and bottom */
            text-align: left; /* Aligns text to the left as per UI */
            /* Using your exact banner image */
            background: url('../images/loginbanner.png') no-repeat center center;
            background-size: cover;
            min-height: 280px;
        }

        .branding-section .logo-wrapper img {
            width: 50px; /* Adjust size as needed */
        }
        
        /* Sub-wrapper for logo text */
        .logo-wrapper div {
            margin-top: 5px;
        }
        
        .logo-wrapper .brand-name {
            display: block;
            font-weight: 600;
            font-size: 1.2rem;
        }
        .logo-wrapper .tagline {
            display: block;
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .branding-section h1 {
            font-size: 2.2rem;
            font-weight: 600;
            line-height: 1.3;
            margin-top: 20px; /* Space between logo and headline */
            align-self: flex-start; /* Aligns to the bottom of the flex container space */
        }

        /* --- Form Section --- */
        .form-section {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 100%;
        }

        .form-section h2 {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--text-color-dark);
            margin-bottom: 30px;
            text-align: center;
        }
        
        .login-form {
            width: 100%;
            max-width: 350px;
            margin: 0 auto;
        }

        /* --- Alert Box Styles --- */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 8px;
            width: 100%;
            text-align: center;
        }
        .alert-danger {
            color: var(--alert-danger-text);
            background-color: var(--alert-danger-bg);
            border-color: var(--alert-danger-text);
        }
        .alert-success {
            color: var(--alert-success-text);
            background-color: var(--alert-success-bg);
            border-color: var(--alert-success-text);
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
        }
        .input-group input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(74, 137, 220, 0.15);
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            color: #fff;
        }
        .btn-primary:hover {
            background-color: #3a7ac8;
        }

        .btn-google {
            background-color: #fff;
            color: var(--text-color-light);
            border: 1px solid var(--border-color);
        }
        .btn-google:hover {
            background-color: #fafafa;
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #ccc;
            margin: 25px 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-color);
        }
        .divider:not(:empty)::before { margin-right: .5em; }
        .divider:not(:empty)::after { margin-left: .5em; }
        
        .signup-link {
            text-align: center;
            margin-top: 25px;
            font-size: 0.9rem;
            color: var(--text-color-light);
        }
        .signup-link a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
        }
        .signup-link a:hover {
            text-decoration: underline;
        }

        /* --- Desktop Responsive Styles --- */
        @media (min-width: 768px) {
            .login-container {
                flex-direction: row;
            }

            .branding-section {
                flex-basis: 50%; /* Set a fixed basis */
                padding: 50px;
            }

            .form-section {
                flex-basis: 50%; /* Set a fixed basis */
                padding: 20px 50px;
            }

            .form-section h2, .login-form {
                text-align: left;
                margin-left: 0;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>

    <main class="login-container">
        
        <!-- Branding Section -->
        <section class="branding-section">
            <div class="logo-wrapper">
                <!-- IMPORTANT: Use a white version of your logo for this design to match -->
                <img src="../images/logo_wbg.png" alt="CivicLink Logo">
                <div>
                    <span class="brand-name">CivicLink</span>
                    <span class="tagline">Connecting Communities, Solving Issues</span>
                </div>
            </div>
            <h1>Connecting Communities.<br>Building Better Cities.</h1>
        </section>

        <!-- Form Section -->
        <section class="form-section">
            <!-- IMPORTANT: Corrected the form action attribute -->
            <form action="../handlers/login_handler.php" method="POST" class="login-form">
                <h2>Sign In to Your Account</h2>
                
                <?php 
                // Display success message from registration
                if (!empty($_GET['status']) && $_GET['status'] == 'success') {
                    echo '<div class="alert alert-success">Registration successful! You can now log in.</div>';
                }
                // Display error messages from login handler
                if (!empty($_GET['error'])) {
                    echo '<div class="alert alert-danger">' . htmlspecialchars(urldecode($_GET['error'])) . '</div>';
                }
                ?>

                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Sign In</button>

                <div class="divider">OR</div>

                <button type="button" class="btn btn-google">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 48 48"><g><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.42-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path><path fill="none" d="M0 0h48v48H0z"></path></g></svg>
                    Continue with Google
                </button>

                <p class="signup-link">
                    <!-- IMPORTANT: Changed href to your actual register page name -->
                    Don't have an account? <a href="sign-up.php">Sign Up</a>
                </p>
            </form>
        </section>

    </main>

</body>
</html>