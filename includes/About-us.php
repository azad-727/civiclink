<?php include 'header2.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us | CivicLink</title>
    <style>
      body {
        font-family: "Poppins", sans-serif;
        margin: 0;
        background: #ebebeb;
        color: #212529;
      }
      .logo {
        font-size: 1.8rem;
        font-weight: bold;
      }
      .nav-links {
        list-style: none;
        display: flex;
        gap: 24px;
      }
      .nav-links li a {
        color: #fff;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
      }
      .nav-links li a:hover {
        color: #cfcfcf;
      }
      .about-container {
        max-width: 850px;
        margin: 40px auto;
        background: #fff;
        padding: 32px 28px;
        border-radius: 16px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
      }
      section {
        margin-bottom: 28px;
      }
      section h2 {
        font-size: 1.35rem;
        color: #1546a0;
        margin-bottom: 8px;
      }
      .how-it-works ul {
        padding: 0;
        margin-left: 20px;
      }
      .how-it-works li {
        margin-bottom: 8px;
        font-size: 1rem;
      }
      .workflow-img,
      .impact-img {
        width: 100%;
        max-width: 400px;
        display: block;
        margin: 18px auto 0 auto;
        border-radius: 12px;
        box-shadow: 0 1px 8px rgba(21, 70, 160, 0.1);
      }
      .join-us {
        text-align: center;
      }
      #contactBtn {
        background: #1546a0;
        color: #fff;
        border: none;
        outline: none;
        padding: 14px 36px;
        border-radius: 8px;
        font-size: 1.1rem;
        cursor: pointer;
        margin-top: 16px;
        transition: background 0.2s;
      }
      #contactBtn:hover {
        background: #1e70e5;
      }
      footer {
        padding: 18px 0;
        text-align: center;
        background: #1546a0;
        color: #fff;
        margin-top: 44px;
      }
      @media (max-width: 600px) {
        .about-container {
          padding: 18px 6px;
          margin: 20px 3px;
        }
        .workflow-img,
        .impact-img {
          width: 80px;
          height: 80px;
          max-width: 180px;
        }
        .navbar {
          padding: 12px 8px;
        }
        .nav-links {
          gap: 10px;
        }
      }
    </style>
  </head>
  <body>
    <main class="about-container">
      <section class="mission">
        <h2>Our Mission</h2>
        <p>
          CivicLink’s mission is to transform local voices into positive action.
          By enabling real-time reporting of civic issues, we help prioritize
          repairs and foster trust between residents and city officials.
        </p>
      </section>
      <section class="how-it-works">
        <h2>How It Works</h2>
        <ul>
          <li>
            Submit issues with photos, locations, and descriptions using our
            simple apps.
          </li>
          <li>
            Reports are shared with local authorities and visible to all users.
          </li>
          <li>Track status, verify issues, and collaborate for change.</li>
        </ul>
        <img
          class="workflow-img"
          src="WhatsApp-Image-2025-10-29-at-19.11.25_0eaf979f.jpg"
          alt="Issue Submission"
        />
      </section>
      <section class="impact">
        <h2>Our Impact</h2>
        <p>
          Thousands of citizens have made their communities better since launch.
          Every report counts for local improvement and smarter cities.
        </p>
        <img
          class="impact-img"
          src="WhatsApp-Image-2025-10-29-at-19.11.26_bc47285c.jpg"
          alt="Community Success"
        />
      </section>
      <section class="join-us">
        <h2>Join Us</h2>
        <p>
          Whether you are reporting a pothole or advocating for park safety,
          CivicLink is your voice for change. Together, we build stronger
          communities—one report at a time.
        </p>
        <button id="contactBtn">Contact Us</button>
      </section>
    </main>
    <?php include 'footer.php'; ?>
    <script>
      document
        .getElementById("contactBtn")
        .addEventListener("click", function () {
          alert(
            "Thank you for your interest! Please contact us at info@civiclink.com."
          );
        });
    </script>
  </body>
</html>