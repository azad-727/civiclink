<?php
session_start();

include 'header2.php';  
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php?error=pleaselogin");
    exit;
}
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />

<style>
    :root {
        --primary-blue: #3B82F6;
        --light-gray-bg: #F9FAFB;
        --border-color: #D1D5DB;
        --text-color-light: #6B7280;
        --text-color-dark: #1F2937;
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
        --alert-danger-bg: #FEE2E2;
        --alert-danger-text: #B91C1C;
    }

    body {
        background-color: var(--light-gray-bg);
        font-family: 'Poppins', sans-serif; 
    }
    .report-page-container {
        display: flex;
        justify-content: center;
        align-items: flex-start; /* Aligns card to the top */
        padding: 50px 15px; /* Default padding for mobile */
        width: 100%;
        min-height: 100vh;
    }
   .report-card {
        background-color: #fff;
        padding: 30px 40px;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        width: 100%;
        max-width: 750px; /* Max width for desktop */
    }

    .report-title {
        font-size: 2rem;
        font-weight: 600;
        color: var(--text-color-dark);
        text-align: center;
        margin-bottom: 30px;
    }
    
    .alert {
        padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 8px;
        text-align: center; color: var(--alert-danger-text); background-color: var(--alert-danger-bg);
    }

    .report-form .input-group {
        margin-bottom: 25px;
    }

    .report-form label {
        display: block; font-weight: 500; color: var(--text-color-dark); margin-bottom: 8px;
    }

    .report-form input[type="text"],
    .report-form textarea,
    .report-form select {
        width: 100%; padding: 12px 15px; border: 1px solid var(--border-color);
        border-radius: 8px; font-size: 1rem; font-family: inherit; transition: all 0.2s ease;
    }
    
    .report-form input:focus, .report-form textarea:focus, .report-form select:focus {
        outline: none; border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .report-form textarea { resize: vertical; }

    /* Photo Upload Button Style */
    .upload-btn {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        width: 100%; padding: 12px; border-radius: 8px; border: 1px dashed var(--border-color);
        background-color: #F9FAFB; color: var(--text-color-light); cursor: pointer; transition: all 0.2s ease;
    }
    .upload-btn:hover { background-color: #F3F4F6; border-color: var(--primary-blue); }
    .upload-btn svg { width: 20px; height: 20px; }
    .upload-input { display: none; }

    /* Map Styles */
    #map-container { margin-bottom: 25px; }
    #reportMap { height: 300px; width: 100%; border-radius: 12px; border: 1px solid var(--border-color); z-index: 1; }
    .map-instruction { text-align: center; font-size: 0.9rem; color: var(--text-color-light); margin-top: 10px; }

    /* Current Location Button Styles */
    .location-actions {
        display: flex;
        flex-wrap: wrap; /* Allows button to wrap on very small screens */
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        gap: 10px; /* Adds space between label and button if they wrap */
    }

    .location-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background-color: #fff;
        color: var(--text-color-dark);
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .location-btn:hover { background-color: #F3F4F6; border-color: var(--primary-blue); color: var(--primary-blue); }
    .location-btn svg { width: 18px; height: 18px; }

    /* Submit Button Styles */
    .submit-btn {
        width: 100%; padding: 15px; border: none; border-radius: 8px; background-color: var(--primary-blue);
        color: #fff; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: background-color 0.2s ease;
    }
    .submit-btn:hover { background-color: #2563EB; }

    /* --- RESPONSIVE STYLES (Media Queries) --- */

    /* For Tablets and smaller screens (e.g., up to 768px) */
    @media (max-width: 768px) {
        .report-page-container {
            padding: 20px 15px; /* Reduce top/bottom padding */
        }
        .report-card {
            padding: 25px; /* Reduce card padding */
        }
        .report-title {
            font-size: 1.75rem; /* Make title smaller */
            margin-bottom: 20px;
        }
        #reportMap {
            height: 250px; /* Make map a bit smaller */
        }
    }

    /* For Mobile phones (e.g., up to 480px) */
    @media (max-width: 480px) {
        .report-card {
            padding: 20px 15px; /* Further reduce card padding */
            border-radius: 15px;
        }
        .report-title {
            font-size: 1.5rem; /* Even smaller title */
        }
        .report-form label {
            font-size: 0.9rem; /* Slightly smaller labels */
        }
        .report-form input[type="text"],
        .report-form textarea,
        .report-form select {
            padding: 10px 12px; /* Smaller input padding */
            font-size: 0.95rem;
        }
        .location-btn {
            width: 100%; /* Make button full-width */
            justify-content: center; /* Center the content */
        }
        .submit-btn {
            padding: 12px;
            font-size: 1rem;
        }

    .leaflet-control-geosearch form {
    border-radius: 8px !important;
    border: 1px solid var(--border-color) !important;
    box-shadow: none !important;
    }

    .leaflet-control-geosearch form input {
    height: 40px;
    padding: 0 15px;
    font-family: 'Poppins', sans-serif;
    font-size: 0.95rem;
    outline: none !important;
    transition: all 0.2s ease;
    }

    .leaflet-control-geosearch .results {
    border-radius: 8px !important;
    border: 1px solid var(--border-color) !important;
    }

    .leaflet-control-geosearch a.glass {
    border-radius: 8px 0 0 8px !important;
    border-right: 1px solid var(--border-color) !important;
    }
    }
</style>

<main class="report-page-container">
    <div class="report-card">
        <h1 class="report-title">Report an Issue</h1>

        <?php 
        if (!empty($_GET['error'])) {
            echo '<div class="alert">' . htmlspecialchars(urldecode($_GET['error'])) . '</div>';
        }
        ?>

        <form action="../handlers/report_handlers.php" method="POST" class="report-form" enctype="multipart/form-data">
            
            <div class="input-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" placeholder="e.g., Pothole on Main Street" required>
            </div>

            <div class="input-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Provide details of the problem" rows="4" required></textarea>
            </div>
            
            <div class="input-group">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="" disabled selected>Select the issue category</option>
                    <option value="Roads">Pothole / Road Damage</option>
                    <option value="Waste">Garbage Collection Issue</option>
                    <option value="Electricity">Streetlight Outage</option>
                    <option value="Water">Water Leakage / Supply Issue</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="input-group">
                <label for="photo" class="upload-btn">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    <span>Upload Photo (Optional)</span>
                </label>
                <input type="file" id="photo" name="photo" class="upload-input" accept="image/*">
            </div>

            <div id="map-container">
                <div class="location-actions">
                    <label>Location <sup>*</sup></label>
                    <button type="button" id="currentLocationBtn" class="location-btn">
                        <!-- SVG Icon for location button -->
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Current Location
                    </button>
                </div>
                <div id="reportMap"></div>
                <p class="map-instruction">Or click map to manually set the location</p>
            </div>

            <!-- Hidden inputs for coordinates are crucial -->
            <input type="hidden" id="lat" name="lat" required>
            <input type="hidden" id="lng" name="lng" required>

            <button type="submit" class="submit-btn">Submit Report</button>
        </form>
    </div>
</main>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script src="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js"></script>
<script src= "../assets/report-map.js"></script>

<?php 
include 'footer.php'; 
?>