<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Terms of Service | CivicLink</title>

  <style>
    body {
      margin: 0;
      background-color: #EBEBEB;
      font-family: "Poppins", sans-serif;
      color: #1e293b;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .terms-page {
      flex: 1;
      padding: 40px 20px;
    }

    .terms-page .container {
      max-width: 1000px;
      margin: 0 auto 40px;
      background: #ffffff;
      border-radius: 12px;
      padding: 40px;
      box-shadow: 0 1px 5px rgba(0, 0, 0, 0.08);
    }

    .terms-page h1 {
      font-size: 2rem;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 10px;
    }

    .terms-page p.subtitle {
      color: #475569;
      margin-bottom: 25px;
    }

    .terms-page .effective-date {
      color: #64748b;
      font-size: 14px;
      margin-bottom: 30px;
      text-align: right;
    }

    .terms-page h2 {
      font-size: 1.2rem;
      color: #0f172a;
      margin-top: 30px;
      margin-bottom: 10px;
    }

    .terms-page p {
      color: #475569;
      line-height: 1.7;
      margin-bottom: 15px;
    }

    .terms-page a {
      color: #2563eb;
      text-decoration: none;
    }

    .terms-page a:hover {
      text-decoration: underline;
    }

    .terms-page hr {
      border: none;
      border-top: 1px solid #e2e8f0;
      margin-bottom: 30px;
    }

    @media (max-width: 768px) {
      .terms-page {
        padding: 20px;
      }

      .terms-page .container {
        padding: 25px;
      }
    }
  </style>
</head>

<body>

  <?php include 'header2.php'; ?>
  <main class="terms-page">
    <div class="container">
      <h1>Terms of Service</h1>
      <p class="subtitle">This document outlines the rules and policies for using our platform.</p>
      <p class="effective-date">Effective Date: May 22, 2024</p>

      <hr />

      <h2>1. Acceptance of Terms</h2>
      <p>
        By accessing or using CivicLink, you agree to comply with these Terms of Service.
        If you do not agree, please do not use our website or services.
      </p>

      <h2>2. User Accounts</h2>
      <p>
        Users may be required to create an account to access certain features.
        You are responsible for maintaining the confidentiality of your login information
        and all activities under your account.
      </p>

      <h2>3. Use of Our Platform</h2>
      <p>
        You agree to use CivicLink only for lawful purposes and in accordance with applicable laws and regulations.
        You may not use our services to distribute spam, harmful content, or engage in fraudulent activity.
      </p>

      <h2>4. Intellectual Property</h2>
      <p>
        All materials on CivicLink, including text, graphics, logos, and code, are owned by CivicLink
        and protected by copyright and trademark laws. You may not copy, modify, or distribute our content
        without prior written consent.
      </p>

      <h2>5. Limitation of Liability</h2>
      <p>
        CivicLink is not liable for any direct or indirect damages resulting from the use or inability to use our services,
        including data loss, downtime, or unauthorized access.
      </p>

      <h2>6. Changes to These Terms</h2>
      <p>
        We may update our Terms of Service periodically. Updates will be posted on this page with a revised effective date.
        Continued use of CivicLink after changes implies acceptance of the new terms.
      </p>

      <h2>7. Contact Us</h2>
      <p>
        For any questions about these Terms, please contact our legal team at
        <a href="mailto:support@civiclink.com">support@civiclink.com</a>.
      </p>
    </div>
  </main>

  <?php include 'footer.php'; ?>

</body>
</html>
