<?php
// PHP session start or other server-side logic can go here.

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join CivicLink</title>
    
    <!-- Google Fonts for a modern, clean look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- Universal Styles & Variables --- */
        :root {
            --primary-blue: #3b82f6; /* A modern, friendly blue */
            --light-gray-bg: #f4f6f8;
            --border-color: #e0e4e8;
            --text-color-light: #6c757d;
            --text-color-dark: #333;
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
            padding: 20px;
        }

        /* --- Main Container for the Signup Panel --- */
        .signup-container {
            display: flex;
            flex-direction: column; /* Mobile-first: vertical stack */
            width: 100%;
            max-width: 950px;
            background-color: #fff;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border-radius: 16px; /* Applied for desktop, but good to have */
        }

        /* --- Branding Section --- */
        .branding-section {
            padding: 40px;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: left;
            /* Using your provided image with a blue overlay */
            background:
                        url('../images/signup-banner.png') no-repeat center center;
            background-size: cover;
            min-height: 300px;
        }

        .branding-section .logo img {
            width: 50px;
            margin-bottom: 5px;
        }

        .branding-section .logo .brand-name {
            display: block;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .branding-section h1 {
            font-size: 2.3rem;
            font-weight: 600;
            line-height: 1.3;
            margin-top: 20px;
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
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--text-color-dark);
            margin-bottom: 30px;
            text-align: center;
        }
        
        .signup-form {
            width: 100%;
            max-width: 380px;
            margin: 0 auto;
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s ease;
        }
        .input-group input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .terms-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
            font-size: 0.9rem;
            color: var(--text-color-light);
        }
        .terms-group input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary-blue);
        }
        .terms-group a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
        }
        .terms-group a:hover {
            text-decoration: underline;
        }

        .btn-create-account {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            background-color: var(--primary-blue);
            color: #fff;
            transition: background-color 0.2s ease-in-out;
        }
        .btn-create-account:hover {
            background-color: #2563eb;
        }

        /* --- Desktop Responsive Styles --- */
        @media (min-width: 768px) {
            .signup-container {
                flex-direction: row;
            }

            .branding-section {
                flex-basis: 50%;
                padding: 50px;
                min-height: 600px; /* Give it a consistent height */
            }

            .form-section {
                flex-basis: 50%;
                padding: 20px 50px;
            }

            .form-section h2, .signup-form {
                text-align: left;
                margin-left: 0;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>

    <main class="signup-container">
        
        <!-- Branding Section  -->
        <section class="branding-section">
            <div class="logo">
                <img src="../images/logo_wbg.png" alt="CivicLink Logo">
                <span class="brand-name">CivicLink</span>
            </div>
            <h1 class>Connecting Communities.<br>Building Better Cities.</h1>
        </section>
        
        

        <!-- Form Section -->
        <section class="form-section">
            <form action="../handlers/register_handlers.php" method="POST" class="signup-form">
                <h2>Join CivicLink</h2>

                <div class="input-group">
                    <input type="text" name="fname" placeholder="Full Name" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group" pattern="/a/">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-group">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                
                <div class="terms-group">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">I agree to <a href="#">Terms of Service</a></label>
                </div>
                
                <button type="submit" class="btn-create-account">Create Account</button>
            </form>
        </section>

    </main>

</body>
<script>
    const pass_regex=
</script>
</html>