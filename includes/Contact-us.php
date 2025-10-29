<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Get in Touch</title>
  <style>
      * {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
   font-family: "Poppins", sans-serif;
}

body {
  background: #EBEBEB;
  color: #1c1f24;
}

.contact-section {
  padding: 60px 80px;
}

.contact-container {
  display: flex;
  justify-content: space-between;
  gap: 40px;
  flex-wrap: wrap;
}

.contact-info {
  flex: 1;
  min-width: 380px;
}

.contact-info h1 {
  font-size: 2.3rem;
  color: #0d1a33;
  margin-bottom: 10px;
}

.contact-info p {
  color: #606d80;
  margin-bottom: 30px;
}

.contact-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
  gap: 20px;
}

.card {
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  text-align: left;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.icon {
  font-size: 1.8rem;
  margin-bottom: 8px;
}

.card h3 {
  font-size: 1.1rem;
  margin-bottom: 8px;
  color: #0d1a33;
}

.card p {
  color: #4a4f59;
}

.card small {
  color: #7c8592;
}

.btn {
  background-color: #0066ff;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 10px 16px;
  margin-top: 10px;
  cursor: pointer;
  transition: background 0.2s ease;
}

.btn:hover {
  background-color: #004bcc;
}

.contact-side {
  flex: 0.9;
  min-width: 320px;
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.map-card {
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.map-placeholder {
  background: #e8eef8;
  height: 180px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  color: #607196;
}

.map-info {
  padding: 16px;
}

.map-info h4 {
  color: #0d1a33;
  font-size: 1rem;
  margin-bottom: 4px;
}

.map-info p {
  color: #606d80;
  font-size: 0.9rem;
}

.faq {
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.faq h3 {
  font-size: 1.1rem;
  margin-bottom: 12px;
  color: #0d1a33;
}

.faq-item {
  background: #f3f6fa;
  border-radius: 8px;
  padding: 10px 14px;
  margin-bottom: 8px;
  font-size: 0.95rem;
  color: #333;
  cursor: pointer;
  transition: background 0.2s ease;
}

.faq-item:hover {
  background: #e6efff;
}

  </style>
</head>
<body>
 <?php include 'header2.php'; ?>
  <section class="contact-section">
    <div class="contact-container">
      <div class="contact-info">
        <h1>Get in Touch</h1>
        <p>We're here to help answer questions and provide support</p>

        <div class="contact-cards">
          <div class="card">
            <div class="icon">🛠️</div>
            <h3>Report a Problem</h3>
            <button class="btn">Submit an Issue</button>
          </div>

          <div class="card">
            <div class="icon">📧</div>
            <h3>General Inquiries</h3>
            <p>hello@civiclink.org</p>
          </div>

          <div class="card">
            <div class="icon">🎙️</div>
            <h3>Media & Press</h3>
            <p>media@civiclink.org</p>
          </div>

          <div class="card">
            <div class="icon">📞</div>
            <h3>Phone Support</h3>
            <p>(555) 123-667</p>
            <small>Mon–Fri, 9am–3pm EST</small>
          </div>
        </div>
      </div>

      <div class="contact-side">
        <div class="map-card">
          <div class="map-placeholder">📍 Map Preview</div>
          <div class="map-info">
            <h4>Swcredited By</h4>
            <p>Meseto Nottle Krioter Fugy Iboeen<br>May 3, 2024</p>
          </div>
        </div>

        <div class="faq">
          <h3>Frequently Asked Questions</h3>
          <div class="faq-item">How do I submit an issue?</div>
          <div class="faq-item">What happens after I report a problem?</div>
        </div>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>  
  <script>
document.querySelectorAll('.faq-item').forEach(item => {
  item.addEventListener('click', () => {
    alert(`You clicked on: "${item.textContent}"`);
  });
});

  </script>
</body>
</html>
