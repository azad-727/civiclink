<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Privacy Policy | CivicLink</title>
<style>
  body {
    font-family: "Poppins", sans-serif;
    background: #EBEBEB;
    margin: 0;
    padding: 0;
    color: #222;
  }

  .container {
    width: 90%;
    max-width: 900px;
    margin: 50px auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
    padding: 40px;
  }

  h1 {
    font-size: 2.2rem;
    color: #0a2540;
    margin-bottom: 0.3rem;
  }

  p.subtitle {
    color: #555;
    font-size: 1rem;
    margin-top: 0;
  }

  .effective-date {
    text-align: right;
    color: #666;
    font-size: 0.9rem;
    border-top: 1px solid #ddd;
    margin-top: 20px;
    padding-top: 10px;
  }

  .section {
    margin-top: 30px;
  }

  .section h2 {
    color: #0a2540;
    font-size: 1.3rem;
    margin-bottom: 10px;
  }

  .section p {
    color: #444;
    font-size: 0.95rem;
    line-height: 1.6;
  }

  .highlight {
    color: #0a67c8;
    font-weight: 600;
  }

  button {
    background-color: #0a67c8;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.95rem;
    margin-top: 25px;
  }

  button:hover {
    background-color: #084f9c;
  }

  @media (max-width: 600px) {
    .container {
      padding: 25px;
    }
  }
</style>
</head>
<body>
  <?php include 'header2.php'; ?>
  <div class="container">
    <h1>Privacy Policy</h1>
    <p class="subtitle">
      Your privacy is important to us. This policy explains how we collect, use, and protect your information.
    </p>
    <p class="effective-date">Effective Date: May 22, 2024</p>

    <div class="section">
      <h2>Information We Collect</h2>
      <p>
        We collect personal information such as your name, email address, and any details you share while using <span class="highlight">CivicLink</span>. 
        This helps us improve our services and provide a better experience.
      </p>
    </div>

    <div class="section">
      <h2>How We Use Your Information</h2>
      <p>
        Your information is used only to improve our services, communicate updates, and ensure security. 
        We do not sell or share your data with third parties without consent.
      </p>
    </div>

    <div class="section">
      <h2>Data Protection</h2>
      <p>
        We use secure systems and encryption to protect your data from unauthorized access. 
        You can contact our team anytime for privacy concerns.
      </p>
    </div>

    <button onclick="contactPrivacy()">Contact Privacy Team</button>
  </div>
<?php include 'footer.php'; ?>
  <script>
    function contactPrivacy() {
      alert("Redirecting to Privacy Team contact form...");
    }
  </script>
</body>
</html>
