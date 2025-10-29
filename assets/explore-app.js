document.addEventListener('DOMContentLoaded', function () {
    // --- SETUP & DOM ELEMENTS ---
    const map = L.map('exploreMap').setView([20.5937, 78.9629], 5);
    const issuesListContainer = document.getElementById('issues-list-container');
    
    // POTENTIAL ISSUE FIX #1: Check if these elements exist before trying to use them.
    // This prevents errors if you change the HTML later.
    const reportsTitle = document.getElementById('reports-title');
    const mobileReportsTitle = document.getElementById('mobile-reports-title');
    
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_labels_under/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap &copy; CARTO',
    }).addTo(map);

    // --- HELPER FUNCTIONS ---
    function getStatusClass(status) {
        status = status ? status.toLowerCase() : 'open';
        if (status === 'under review') return 'status-review';
        if (status === 'resolved') return 'status-resolved';
        return 'status-open';
    }

    // --- CORE LOGIC ---

    // 1. Function to fetch data (No changes needed here, it's working)
    async function loadIssues(lat, lng) {
        // Using a root-relative path is the most robust way.
        let apiUrl = '/civiclink-api/handlers/explore_handler.php'; 
        if (lat && lng) {
            apiUrl += `?lat=${lat}&lng=${lng}`;
            if (reportsTitle) reportsTitle.textContent = "Nearby Civic Reports";
            if (mobileReportsTitle) mobileReportsTitle.textContent = "Nearby Civic Reports";
        }
        
        try {
            const response = await fetch(apiUrl);
            if (!response.ok) throw new Error('Network response was not ok');
            const issues = await response.json();
            
            // CRITICAL FIX #2: Call the render/plot functions AFTER data is confirmed.
            renderUI(issues);

        } catch (error) {
            issuesListContainer.innerHTML = '<p style="color:red;">Error loading issues. Please try again.</p>';
            console.error('Fetch error:', error);
        }
    }
    
    // MAJOR REFACTOR: Combine rendering and plotting into one function
    // This solves potential race conditions and makes the code cleaner.
    function renderUI(issues) {
        // Part A: Render the issue cards in the list
        issuesListContainer.innerHTML = ''; // Clear loading message
        if (issues.length === 0) {
            issuesListContainer.innerHTML = '<p>No issues found in this area. Be the first to <a href="report.php">report one</a>!</p>';
            return;
        }

        issues.forEach(issue => {
            const locationText = issue.distance ? `${Math.round(issue.distance * 10) / 10} km away` : issue.username;
            // Use root-relative path for images too, for robustness
            const imageSrc = issue.photo_path ? `/civiclink-api/${issue.photo_path}` : '/civiclink-api/assets/images/default-placeholder.png';
            const statusClass = getStatusClass(issue.status);
            const statusText = issue.status ? issue.status.charAt(0).toUpperCase() + issue.status.slice(1) : 'Open';
            const date = new Date(issue.created_at).toLocaleDateString('en-US', { day: 'numeric', month: 'long' });

            const cardHtml = `
                <div class="issue-card" data-lat="${issue.location_lat}" data-lng="${issue.location_lng}">
                    <img src="${imageSrc}" alt="Issue Image" class="issue-card-img">
                    <div class="issue-card-content">
                        <div class="card-top-row">
                            <h3 class="card-title">${issue.title}</h3>
                            <span class="card-status ${statusClass}">${statusText}</span>
                        </div>
                        <div class="card-meta">
                            <div class="card-meta-item">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <span>${locationText}</span>
                            </div>
                            <div class="card-meta-item">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>${date}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            issuesListContainer.insertAdjacentHTML('beforeend', cardHtml);
        });

        // Part B: Plot the issue dots on the map
        // Clear previous layers to prevent duplicate markers on reload
        map.eachLayer((layer) => {
            if (layer instanceof L.CircleMarker) {
                map.removeLayer(layer);
            }
        });

        issues.forEach(issue => {
            const status = issue.status ? issue.status.toLowerCase() : 'open';
            let dotColor = '#3B82F6'; // Open
            if (status === 'under review') dotColor = '#F59E0B'; // Review
            if (status === 'resolved') dotColor = '#10B981'; // Resolved

            const circleMarker = L.circleMarker([issue.location_lat, issue.location_lng], {
                radius: 6, fillColor: dotColor, color: '#fff', weight: 1.5, opacity: 1, fillOpacity: 0.8
            }).addTo(map);
            
            circleMarker.bindPopup(`<b>${issue.title}</b><br>Status: ${status}`);
        });

        // Part C: Add click listeners to the NEWLY created cards
        // This must be done AFTER the cards are added to the DOM.
        document.querySelectorAll('.issue-card').forEach(card => {
            card.addEventListener('click', function() {
                const lat = this.dataset.lat;
                const lng = this.dataset.lng;
                if(lat && lng) {
                    // Only flyTo on desktop, as the map isn't visible on mobile
                    if (window.innerWidth >= 992) {
                        map.flyTo([lat, lng], 15);
                    }
                }
            });
        });
    }
    
    // 4. Get user's location and initialize the app
    function initialize() {
        if ('geolocation' in navigator) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    map.setView([userLat, userLng], 13);
                    loadIssues(userLat, userLng);
                },
                () => {
                    console.warn("User denied location. Loading default view.");
                    loadIssues(null, null); // Load without location
                }
            );
        } else {
            console.log('Geolocation not available. Loading default view.');
            loadIssues(null, null); // Load without location
        }
    }
    
    // --- START THE APP ---
    initialize();
});