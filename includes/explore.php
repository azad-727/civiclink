<?php 
session_start();
// Use your primary header file. I'm assuming it's header2.php
include '../includes/header2.php'; 
?>

<!-- Required CSS for the Leaflet map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

<!-- All the CSS for this page is self-contained here -->
<style>
    /* --- THEME & VARIABLES --- */
    :root {
        --primary-blue: #3B82F6; 
        --light-gray-bg: #F9FAFB; 
        --border-color: #E5E7EB;
        --text-color-light: #6B7280; 
        --text-color-dark: #1F2937; 
        --card-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        --status-open-bg: #DBEAFE; 
        --status-open-text: #1E40AF;
        --status-review-bg: #FEF3C7; 
        --status-review-text: #92400E;
        --status-resolved-bg: #D1FAE5; 
        --status-resolved-text: #065F46;
    }

    /* --- GENERAL LAYOUT --- */
    body { 
        background-color: var(--light-gray-bg); 
        font-family: 'Poppins', sans-serif; /* Assumes font is in your header */
    }
    .explore-main-container { 
        padding: 30px; 
        max-width: 1400px; 
        margin: 0 auto; 
    }
    
    /* --- DESKTOP LAYOUT (Default) --- */
    .desktop-layout { 
        display: grid; 
        grid-template-columns: 2fr 1fr; 
        gap: 30px; 
    }
    .map-section { 
        position: relative; 
        border-radius: 20px; 
        overflow: hidden; 
        box-shadow: var(--card-shadow); 
        /* Set height relative to viewport, minus header/padding */
        height: calc(100vh - 150px); 
    }
    .map-title { 
        position: absolute; 
        top: 20px; 
        left: 20px; 
        background: rgba(255,255,255,0.8); 
        padding: 10px 20px; 
        border-radius: 12px; 
        font-size: 1.5rem; 
        font-weight: 600; 
        color: var(--text-color-dark); 
        z-index: 1000; 
        backdrop-filter: blur(5px); 
    }
    #exploreMap { 
        width: 100%; 
        height: 100%; 
    }
    
    /* Reports Section (Right Column) */
    .reports-section { 
        background-color: #fff; 
        border-radius: 20px; 
        padding: 20px; 
        box-shadow: var(--card-shadow); 
        display: flex; 
        flex-direction: column; 
        height: calc(100vh - 150px); 
    }
    .reports-header { 
        font-size: 1.5rem; 
        font-weight: 600; 
        color: var(--text-color-dark); 
        margin-bottom: 20px; 
        padding: 0 10px; 
    }
    .issues-list { 
        overflow-y: auto; /* Makes the list scrollable */
        flex-grow: 1; 
        padding: 0 10px; 
    }
    
    /* --- ISSUE CARD STYLES --- */
    .issue-card { 
        display: flex; 
        gap: 15px; 
        background-color: #fff; 
        padding: 15px; 
        border-radius: 12px; 
        border: 1px solid var(--border-color); 
        margin-bottom: 15px; 
        cursor: pointer; 
        transition: all 0.2s ease; 
    }
    .issue-card:hover { 
        border-color: var(--primary-blue); 
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.1); 
    }
    .issue-card-img { 
        width: 70px; 
        height: 70px; 
        border-radius: 8px; 
        object-fit: cover; 
        background-color: var(--light-gray-bg); 
    }
    .issue-card-content { flex-grow: 1; }
    .card-top-row { display: flex; justify-content: space-between; align-items: flex-start; }
    .card-title { font-size: 1.1rem; font-weight: 600; color: var(--text-color-dark); margin-bottom: 5px; }
    .card-status { font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 20px; white-space: nowrap; }
    .status-open { background-color: var(--status-open-bg); color: var(--status-open-text); }
    .status-review { background-color: var(--status-review-bg); color: var(--status-review-text); }
    .status-resolved { background-color: var(--status-resolved-bg); color: var(--status-resolved-text); }
    .card-meta { display: flex; flex-direction: column; align-items: flex-start; gap: 5px; font-size: 0.85rem; color: var(--text-color-light); margin-top: 8px; }
    .card-meta-item { display: flex; align-items: center; gap: 5px; }
    .card-meta-item svg { width: 14px; height: 14px; }
    .card-details-link {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--primary-blue);
    text-decoration: none;
    margin-top: 10px;
    align-self: flex-start; /* Aligns the link to the left */
}
.card-details-link:hover {
    text-decoration: underline;
}
    /* --- FLOATING ACTION BUTTON --- */
    .fab { 
        position: fixed; 
        bottom: 30px; 
        right: 30px; 
        background-color: var(--primary-blue); 
        color: #fff; 
        width: 56px; 
        height: 56px; 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.2); 
        text-decoration: none; 
        font-size: 2rem; 
        line-height: 1;
        z-index: 1000; 
        transition: transform 0.2s ease; 
    }
    .fab:hover { transform: scale(1.1); }
    
    /* --- MOBILE RESPONSIVE STYLES --- */
    .mobile-header { display: none; } /* Hidden by default */

    @media (max-width: 992px) {
        .desktop-layout { 
            grid-template-columns: 1fr; /* Stack columns */
        }
        .map-section { 
            height: 40vh; /* Shorter map on mobile */
        }
        .reports-section { 
            height: auto; /* Let the list grow as needed */
            padding: 15px;
        }
        .explore-main-container { 
            padding: 0; 
        }
        .map-title { 
            display: none; /* Hide desktop map title */
        }
        .reports-header {
             display: none; /* Hide desktop list title */
        }
        .mobile-header {
            display: block; /* Show mobile-only title */
            padding: 20px 20px 0 20px;
            font-size: 1.8rem;
        }
    }
</style>

<div class="explore-main-container">
    
    <!-- This title is ONLY visible on mobile -->
    <h1 class="mobile-header" id="mobile-reports-title">Civic Reports</h1>

    <div class="desktop-layout">
        
        <!-- Map Section (Left Column) -->
        <div class="map-section">
            <h2 class="map-title">Problem Hotspots</h2>
            <div id="exploreMap"></div>
        </div>

        <!-- Reports Section (Right Column) -->
        <div class="reports-section">
            <h2 class="reports-header" id="reports-title">Civic Reports</h2>
            <!-- JavaScript will populate this list -->
            <div class="issues-list" id="issues-list-container">
                <p>Loading issues...</p>
            </div>
        </div>
    </div>
</div>

<!-- Floating Action Button to Report Issue -->
<a href="report.php" class="fab">+</a>

<!-- JavaScript includes -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<!-- Make sure the path to your JS file is correct -->
<script src="/civiclink-api/assets/explore-app.js"></script>
<?php include '../includes/footer.php'; ?>