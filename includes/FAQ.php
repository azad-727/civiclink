<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Help Center</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background: #EBEBEB;
      color: #1e293b;
    }

    header, .navbar, .nav-container {
      width: 100%;
      top: 0;
      left: 0;
      position: relative;
      z-index: 1000;
    }

    main {
      padding: 40px; 
    }

    h1 {
      font-size: 2.2rem;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 10px;
    }

    p.subtitle {
      color: #475569;
      margin-bottom: 30px;
    }

    .search-box {
      display: flex;
      align-items: center;
      background: white;
      padding: 12px 18px;
      border-radius: 10px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
      width: 100%;
      max-width: 600px;
      margin-bottom: 40px;
    }

    .search-box input {
      border: none;
      outline: none;
      flex: 1;
      font-size: 16px;
      color: #334155;
    }

    .search-box input::placeholder {
      color: #94a3b8;
    }

    h2 {
      font-size: 1.3rem;
      margin-bottom: 15px;
      color: #0f172a;
    }

    .topics {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-bottom: 40px;
    }

    .topic-card {
      background: white;
      padding: 18px 25px;
      border-radius: 12px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .topic-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .topic-card i {
      color: #2563eb;
      font-size: 18px;
    }

    .faq-section {
      margin-top: 30px;
    }

    .faq-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
      margin-bottom: 15px;
      padding: 20px;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .faq-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .faq-question {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      color: #0f172a;
    }

    .faq-answer {
      display: none;
      margin-top: 10px;
      color: #475569;
      line-height: 1.6;
    }

    .faq-card.active .faq-answer {
      display: block;
    }

    .faq-card.active .faq-question i {
      transform: rotate(45deg);
    }

    .faq-question i {
      transition: transform 0.2s ease;
      font-size: 18px;
      color: #2563eb;
    }

    .contact-link {
      display: block;
      margin-top: 10px;
      color: #2563eb;
      text-decoration: none;
      font-weight: 500;
    }

    .contact-link:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      main {
        padding: 100px 20px 40px;
      }

      .topics {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  
  <?php include 'header2.php'; ?>

  <main>
    <section>
      <h1>How Can We Help?</h1>
      <p class="subtitle">Find answers to common questions about <b>CivicLink</b> and how it works.</p>

      <div class="search-box">
        <input type="text" placeholder="Search for questions..." />
      </div>

      <h2>Browse by Topic</h2>
      <div class="topics">
        <div class="topic-card"><i>📘</i> Getting Started</div>
        <div class="topic-card"><i>📝</i> Reporting Issues</div>
        <div class="topic-card"><i>💼</i> Account Management</div>
        <div class="topic-card"><i>🔒</i> Privacy</div>
        <div class="topic-card"><i>💡</i> Technical Support</div>
      </div>

      <div class="faq-section">
        <h2>Popular Questions</h2>

        <div class="faq-card">
          <div class="faq-question">
            <span>How do I submit an issue?</span>
            <i>+</i>
          </div>
          <div class="faq-answer">
            <p>After submitting an issue, our support team reviews it and takes the necessary steps to resolve the problem quickly.</p>
            <a href="#" class="contact-link">Still need help? Contact our support team</a>
          </div>
        </div>

        <div class="faq-card">
          <div class="faq-question">
            <span>What happens after I report an issue?</span>
            <i>+</i>
          </div>
          <div class="faq-answer">
            <p>We assign your report to the relevant department and keep you updated on its progress through your dashboard.</p>
          </div>
        </div>

        <div class="faq-card">
          <div class="faq-question">
            <span>Can I track the report progress?</span>
            <i>+</i>
          </div>
          <div class="faq-answer">
            <p>Yes, you can track the status of your reports anytime from your CivicLink profile page.</p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include 'footer.php'; ?>

  <script>
    const faqs = document.querySelectorAll(".faq-card");
    faqs.forEach(faq => {
      faq.addEventListener("click", () => {
        faq.classList.toggle("active");
      });
    });
  </script>
</body>
</html>
