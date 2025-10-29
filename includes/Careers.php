<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Join Our Mission</title>

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: "Poppins", sans-serif;
    }

    body {
      background: #EBEBEB;
      color: #1d1f27;
    }

    .careers-section {
      padding: 60px 80px;
    }

    .hero {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 60px;
    }

    .hero-text h1 {
      font-size: 2.5rem;
      color: #0d1a33;
      margin-bottom: 8px;
      text-align:center;
    }

    .hero-text p {
      color: #5c6b80;
      font-size: 1.1rem;
    }

    .primary-btn {
      background: #00509d;
      color: #fff;
      border: none;
      border-radius: 6px;
      padding: 14px 24px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .primary-btn:hover {
      background: #00509d;
    }

    .why-choose {
      margin-bottom: 60px;
    }

    .why-choose h2 {
      font-size: 1.6rem;
      margin-bottom: 24px;
      color: #0d1a33;
    }

    .cards {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .card {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      flex: 1;
      min-width: 220px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .icon {
      font-size: 1.8rem;
      margin-bottom: 10px;
    }

    .card h3 {
      font-size: 1.1rem;
      color: #0d1a33;
      margin-bottom: 6px;
    }

    .card p {
      color: #58657a;
      font-size: 0.95rem;
    }

    .opportunities h2 {
      font-size: 1.6rem;
      margin-bottom: 16px;
      color: #0d1a33;
    }

    .search-bar {
      display: flex;
      gap: 10px;
      margin-bottom: 30px;
    }

    .search-bar input,
    .search-bar select {
      padding: 10px 12px;
      border: 1px solid #d5dce5;
      border-radius: 8px;
      background: #fff;
      font-size: 0.95rem;
      flex: 1;
    }

    .job-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
    }

    .job-card {
      background: #fff;
      border-radius: 12px;
      padding: 18px;
      display: flex;
      align-items: center;
      gap: 15px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .job-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .job-card img {
      border-radius: 50%;
      width: 60px;
      height: 60px;
      object-fit: cover;
    }

    .job-info h3 {
      font-size: 1.05rem;
      color: #0d1a33;
      margin-bottom: 4px;
    }

    .job-info p {
      font-size: 0.9rem;
      color: #58657a;
    }

    .apply-btn {
      margin-left: auto;
      background: #00509d;
      color: #fff;
      border: none;
      border-radius: 6px;
      padding: 8px 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .apply-btn:hover {
      background: #00509d;
    }

    @media (max-width: 768px) {
      .careers-section {
        padding: 40px 20px;
      }
      .hero {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
      }
    }
  </style>
</head>
<body>
  <?php include 'header2.php'; ?>
  <section class="careers-section">
    <div class="hero">
      <div class="hero-text">
        <h1>Join Our Mission</h1>
        <p>Empowering communities through innovative solutions</p>
      </div>
    </div>

    <div class="why-choose">
      <h2>Why Choose Civicion?</h2>
      <div class="cards">
        <div class="card">
          <div class="icon">🤝</div>
          <h3>Impact</h3>
          <p>Make a real difference in local communities.</p>
        </div>

        <div class="card">
          <div class="icon">💬</div>
          <h3>Culture</h3>
          <p>Collaborative, inclusive, and innovative environment.</p>
        </div>

        <div class="card">
          <div class="icon">📈</div>
          <h3>Growth</h3>
          <p>Invest in professional development.</p>
        </div>
      </div>
    </div>

    <div class="opportunities">
      <h2>Explore Opportunities</h2>
      <div class="search-bar">
        <input type="text" placeholder="Search job titles..." id="searchInput" />
        <select>
          <option>Department</option>
          <option>Engineering</option>
          <option>Design</option>
          <option>Community</option>
        </select>
      </div>

      <div class="job-cards">
        <div class="job-card">
          <img src="https://via.placeholder.com/60" alt="Profile" />
          <div class="job-info">
            <h3>Software Engineer</h3>
            <p>Full-time | Remote</p>
          </div>
          <button class="apply-btn">Apply Now</button>
        </div>

        <div class="job-card">
          <img src="https://via.placeholder.com/60" alt="Profile" />
          <div class="job-info">
            <h3>Community Outreach Coordinator</h3>
            <p>Full-time | New York, NY</p>
          </div>
          <button class="apply-btn">Apply Now</button>
        </div>

        <div class="job-card">
          <img src="https://via.placeholder.com/60" alt="Profile" />
          <div class="job-info">
            <h3>UX/UI Designer</h3>
            <p>Full-time | New York, NY</p>
          </div>
          <button class="apply-btn">Apply Now</button>
        </div>
      </div>
    </div>
  </section>
   <?php include 'footer.php'; ?>
  <script>
    const searchInput = document.getElementById('searchInput');
    const jobCards = document.querySelectorAll('.job-card');

    searchInput.addEventListener('input', () => {
      const query = searchInput.value.toLowerCase();
      jobCards.forEach(card => {
        const title = card.querySelector('h3').textContent.toLowerCase();
        card.style.display = title.includes(query) ? 'flex' : 'none';
      });
    });
  </script>

</body>
</html>