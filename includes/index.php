<?php 
session_start();
// Use your main header file
include 'header2.php'; 
?>

<!-- Internal CSS for the Homepage -->
<style>
    /* --- THEME & VARIABLES --- */
    :root {
        --primary-blue: #3B82F6;
        --secondary-blue: #EFF6FF;
        --text-color-dark: #1F2937;
        --text-color-light: #6B7280;
        --border-color: #E5E7EB;
        --light-gray-bg: #F9FAFB;
    }

    /* Override the default container padding from the header for full-width sections */
    .container, .container-fluid {
        padding-left: 0 !important;
        padding-right: 0 !important;
        max-width: 100% !important;
    }

    /* General styling for all sections */
    .section {
        padding: 80px 20px;
        text-align: center;
    }
    .section-content {
        max-width: 1200px;
        margin: 0 auto;
    }
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-color-dark);
        margin-bottom: 20px;
    }
    .section-subtitle {
        font-size: 1.1rem;
        color: var(--text-color-light);
        max-width: 700px;
        margin: 0 auto 50px auto;
    }

    /* --- HERO SECTION --- */
    .hero-section {
        background-color: var(--light-gray-bg);
        padding: 100px 20px;
    }
    .hero-section .section-title {
        font-size: 3.5rem;
        line-height: 1.2;
    }
    .hero-section .section-subtitle {
        font-size: 1.25rem;
        margin-bottom: 40px;
    }
    .hero-cta-buttons {
        display: flex;
        justify-content: center;
        gap: 20px;
    }
    .btn-hero {
        padding: 15px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s ease;
    }
    .btn-primary {
        background-color: var(--primary-blue);
        color: #fff;
    }
    .btn-primary:hover {
        background-color: #2563EB;
    }
    .btn-secondary {
        background-color: #fff;
        color: var(--primary-blue);
        border: 1px solid var(--border-color);
    }
    .btn-secondary:hover {
        background-color: var(--secondary-blue);
    }
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }
    /* --- HOW IT WORKS SECTION --- */
    .how-it-works-section {
        background-color: #fff;
    }
    .steps-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 40px;
        margin-top: 60px;
    }
    .step-card {
        padding: 30px;
    }
    .step-icon {
        background-color: var(--secondary-blue);
        color: var(--primary-blue);
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px auto;
        font-size: 2rem;
        font-weight: 700;
    }
    .step-card h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-color-dark);
        margin-bottom: 10px;
    }
    .step-card p {
        color: var(--text-color-light);
        line-height: 1.6;
    }

    /* --- FEATURES SECTION --- */
    .features-section {
        background-color: var(--light-gray-bg);
    }
    .features-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
        text-align: left;
        align-items: center;
    }
    .feature-item {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }
    .feature-icon {
        background-color: var(--secondary-blue);
        color: var(--primary-blue);
        padding: 15px;
        border-radius: 12px;
        flex-shrink: 0;
    }
    .feature-icon svg { width: 24px; height: 24px; }
    .feature-item h4 {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-color-dark);
        margin-bottom: 5px;
    }
    .feature-item p { color: var(--text-color-light); }

    /* --- RESPONSIVE STYLES --- */
    @media (max-width: 992px) {
        .section-title { font-size: 2rem; }
        .hero-section .section-title { font-size: 2.5rem; }
        .steps-grid { grid-template-columns: 1fr; }
        .features-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
        .hero-cta-buttons { flex-direction: column; }
        .btn-hero { width: 100%; }
    }
.legend-item { display: flex; align-items: center; margin-bottom: 8px; font-size: 0.9rem; }
.legend-item:last-child { margin-bottom: 0; }
.legend-dot { width: 12px; height: 12px; border-radius: 50%; margin-right: 10px; }

.feed-header h4 { font-size: 1.2rem; font-weight: 600; color: var(--text-color-dark); }
.feed-header .icon-group { display: flex; gap: 15px; color: var(--text-color-light); }
/* --- NEW & IMPROVED: LIVE ISSUES DASHBOARD SECTION (Mobile-First) --- */
.live-dashboard-section {
    background-color: #fff;
    padding: 60px 20px;
}

/* MOBILE DEFAULT: A simple, single-column layout */
.dashboard-layout {
    display: flex;
    flex-direction: column; /* Stack map and list vertically */
    gap: 30px;
    max-width: 1200px;
    margin: 60px auto 0 auto;
}

.live-map-container {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    height: 450px; /* A good height for a mobile map */
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
#homepageMap {
    width: 100%;
    height: 100%;
}

.map-overlay {
    position: absolute;
    top: 20px;
    left: 20px;
    right: 20px; /* Allow it to span the width on mobile */
    background: rgba(255,255,255,0.3);
    padding: 20px;
    border-radius: 12px;
    z-index: 401; /* Must be higher than Leaflet's controls */
    backdrop-filter: blur(5px);
    text-align: center;
    /* opacity: 70%; */
}
.map-overlay h3 {
    font-size: 1.8rem; /* Smaller font for mobile */
    font-weight: 700;
    line-height: 1.3;
    color: var(--text-color-dark);
    margin-bottom: 20px;
}

.map-legend {
    display: none; /* Hide the detailed legend on mobile to save space */
}

/* Recent Activity Feed */
.recent-activity-feed {
    background-color: var(--light-gray-bg);
    border-radius: 16px;
    padding: 20px;
}
.feed-header h4 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-color-dark);
    text-align: left;
    margin-bottom: 20px;
}
#activity-list { /* No fixed height, let it grow */ }

.activity-card {
    display: flex; gap: 15px; align-items: center; margin-bottom: 15px;
    background-color: #fff;
    padding: 10px; border-radius: 12px;
    border: 1px solid var(--border-color);
}
.activity-card-img { width: 50px; height: 50px; border-radius: 8px; object-fit: cover; flex-shrink: 0; }
.activity-card-info h5 { font-size: 0.95rem; font-weight: 600; color: var(--text-color-dark); }
.activity-card-info p { font-size: 0.85rem; color: var(--text-color-light); }
.activity-card .card-status { margin-left: auto; font-size: 0.7rem; font-weight: 600; padding: 4px 8px; border-radius: 20px; }


/* --- DESKTOP MEDIA QUERY (Applies ONLY when screen is 992px or wider) --- */
@media (min-width: 992px) {
    .dashboard-layout {
        display: grid;
        grid-template-columns: 2fr 1fr; /* Re-introduce the grid for desktop */
        height: 600px; /* Set a fixed height for the desktop dashboard */
        background-color: var(--light-gray-bg);
        padding: 20px;
        border-radius: 20px;
    }
    
    .recent-activity-feed {
        background-color: #fff; /* White background for the list on desktop */
        height: 100%; /* Fill the grid cell */
        display: flex;
        flex-direction: column;
    }

    #activity-list {
        overflow-y: auto; /* Make the list scrollable on desktop */
        flex-grow: 1;
    }

    .map-overlay {
        text-align: left;
        max-width: 400px; /* Reset max width */
        right: auto; /* Unset right constraint */
    }
    
    .map-overlay h3 {
        font-size: 2.2rem; /* Larger font for desktop */
    }

    .map-legend {
        display: block; /* Show the legend on desktop */
        position: absolute;
        bottom: 20px;
        left: 20px;
        background: rgba(255,255,255,0.85);
        padding: 15px;
        border-radius: 12px;
        z-index: 401;
        backdrop-filter: blur(5px);
    }
    .legend-item { display: flex; align-items: center; margin-bottom: 8px; font-size: 0.9rem; }
    .legend-item:last-child { margin-bottom: 0; }
    .legend-dot { width: 12px; height: 12px; border-radius: 50%; margin-right: 10px; }
}
/* --- TOP CONTRIBUTORS SECTION --- */
.contributors-section {
    background-color: #fff; /* White background to stand out */
}
.contributors-grid {
    display: grid;
    /* Create 5 columns on desktop, which will wrap on smaller screens */
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    margin-top: 60px;
}

.feed-header .icon-group a {
    color: var(--text-color-light);
    transition: color 0.2s ease;
}
.feed-header .icon-group a:hover {
    color: var(--primary-blue);
}
.contributor-card {
    background-color: var(--light-gray-bg);
    border-radius: 16px;
    padding: 25px 20px;
    text-align: center;
    border: 1px solid var(--border-color);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.contributor-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}
.contributor-rank {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-blue);
    margin-bottom: 15px;
}
.contributor-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin: 0 auto 15px auto;
    background-color: var(--border-color);
    /* Simple text-based avatar */
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 600;
    color: var(--primary-blue);
    border: 3px solid #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.contributor-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-color-dark);
    margin-bottom: 5px;
}
.contributor-reports {
    font-size: 0.9rem;
    color: var(--text-color-light);
}
</style>

<!-- HERO SECTION -->
<div class="section hero-section">
    <div class="section-content">
        <h1 class="section-title">Improve Your Community,<br>One Report at a Time.</h1>
        <p class="section-subtitle">CivicLink is a public platform that connects citizens with their local authorities to identify, track, and resolve civic issues collaboratively.</p>
        <div class="hero-cta-buttons">
            <a href="explore.php" class="btn-hero btn-primary">Explore Local Issues</a>
            <?php if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true): ?>
                <a href="login.php" class="btn-hero btn-secondary">Sign in Now</a>
            <?php else: ?>
                <a href="report.php" class="btn-hero btn-secondary">Report an Issue</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- HOW IT WORKS SECTION -->
<div class="section how-it-works-section">
    <div class="section-content">
        <h2 class="section-title">How It Works</h2>
        <p class="section-subtitle">Our process is simple and transparent, designed for quick action and community involvement.</p>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-icon" aria-hidden="true">1</div>
                <h3>Spot & Report</h3>
                <p>See a problem? Use our simple form to report it in seconds. Pin the exact location on the map and add a photo for clarity.</p>
            </div>
            <div class="step-card">
                <div class="step-icon" aria-hidden="true">2</div>
                <h3>Community Verified</h3>
                <p>Other community members can view and verify your report. This helps authorities prioritize the most pressing issues.</p>
            </div>
            <div class="step-card">
                <div class="step-icon" aria-hidden="true">3</div>
                <h3>Track & Resolve</h3>
                <p>Follow the status of your report from "Open" to "Resolved." Get notified when action is taken and see your community improve.</p>
            </div>
        </div>
    </div>
</div>
<!-- LIVE ISSUES DASHBOARD SECTION -->
<div class="section live-dashboard-section" aria-labelledby="live-dashboard-title">
    <div class="section-content">
        <h2 class="section-title">Live Issues Dashboard</h2>
        <p class="section-subtitle">See what's happening in the community right now. The latest reports are updated in real-time.</p>
        
        <div class="dashboard-layout">
            <!-- Map Column -->
            <div class="live-map-container" style = "height:100%; width: 100%;">
                <div class="map-overlay">
                    <h3>Connecting Communities. Building Better Cities.</h3>
                    <a href="includes/explore.php" class="btn-hero btn-primary" style="padding: 12px 25px; font-size: 0.9rem;">Learn More</a>
                </div>
                <div class="map-legend" aria-hidden="true">
                    <div class="legend-item"><span class="legend-dot" style="background-color: #3B82F6;"></span> Roads & Transit</div>
                    <div class="legend-item"><span class="legend-dot" style="background-color: #F59E0B;"></span> Public Safety</div>
                    <div class="legend-item"><span class="legend-dot" style="background-color: #10B981;"></span> Parks & Vandalism</div>
                </div>
                <div id="homepageMap" tabindex="0" aria-label="Live map showing recent issue reports"></div>
            </div>

            <!-- Recent Activity Feed Column -->
            <div class="recent-activity-feed">
                <div class="feed-header">
                    <h4>Recent Activity</h4>
                    <div class="icon-group">
                        <a href="#" aria-label="Filter Activity" title="Filter Activity"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg></a>
                <a href="#" aria-label="Filter Activity" title="Search Activity"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg></a>
            </div>
                </div>
                <!-- This list will be populated by JavaScript -->
                <div id="activity-list" aria-live="polite" aria-atomic="true">
                    <p>Loading recent activity...</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FEATURES SECTION -->
<div class="section features-section" aria-labelledby="features-title">
    <div class="section-content">
        <h2 class="section-title" id="features-title">Platform Features</h2>
        <p class="section-subtitle">We provide the tools needed to make a real-world impact.</p>
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon" aria-hidden="true"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                <div>
                    <h4>Interactive Hotspot Map</h4>
                    <p>Visualize problem areas in your city with a live, color-coded map of all reported issues.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2V7a2 2 0 012-2h2m8-4H5a2 2 0 00-2 2v10a2 2 0 002 2h11l4 4V7a2 2 0 00-2-2z" /></svg></div>
                <div>
                    <h4>Community Discussion</h4>
                    <p>Each issue has its own discussion thread for citizens and officials to collaborate on solutions.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.49l-1.955 5.237a3.5 3.5 0 01-6.844 2.046L6.5 17.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                <div>
                    <h4>Real-time Status Updates</h4>
                    <p>Track the progress of any issue from "Open" to "Under Review" to "Resolved" with our clear status tags.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
                <div>
                    <h4>Direct Authority Connection</h4>
                    <p>Our platform generates clean reports that can be easily shared with municipal corporations.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- TOP CONTRIBUTORS SECTION -->
<div class="section contributors-section">
    <div class="section-content">
        <h2 class="section-title">Top Community Contributors</h2>
        <p class="section-subtitle">Recognizing the citizens who are most active in making our communities better.</p>
        
        <!-- This grid will be populated by JavaScript -->
        <div class="contributors-grid" id="contributors-grid">
            <p>Loading contributors...</p>
        </div>
    </div>
</div>
</div>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="../assets/homepage-dashboard.js"></script> <!-- New JS file -->

<?php 
// Use your main footer file
include 'footer.php'; 
?>