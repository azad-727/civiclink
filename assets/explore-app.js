document.addEventListener('DOMContentLoaded', function () {
    // --- 1. SETUP & DOM ELEMENTS ---
    // These are the main HTML elements our script will interact with.
    const map = L.map('exploreMap').setView([20.5937, 78.9629], 5);
    const issuesListContainer = document.getElementById('issues-list-container');
    const reportsTitle = document.getElementById('reports-title');
    const mobileReportsTitle = document.getElementById('mobile-reports-title');
    
    // Initialize the map's visual layer.
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_labels_under/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap &copy; CARTO',
    }).addTo(map);

    
    // --- 2. HELPER FUNCTIONS ---
    // Small, reusable functions.
    function getStatusClass(status) {
        status = status ? status.toLowerCase() : 'open';
        if (status === 'under review') return 'status-review';
        if (status === 'resolved') return 'status-resolved';
        return 'status-open';
    }

    
    // --- 3. CORE LOGIC FUNCTIONS ---
    
    // Function to fetch data from the backend handler.
    async function loadIssues(lat, lng) {
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
           
            setTimeout(() => {
                map.invalidateSize();
            }, 100);
            // Once data is fetched, call the functions to build the UI.
            renderIssueCards(issues);
            plotIssuesOnMap(issues);
            addCardClickListeners(); // IMPORTANT: Add listeners AFTER cards are rendered.

        } catch (error) {
            issuesListContainer.innerHTML = '<p style="color:red;">Error loading issues. Please try again.</p>';
            console.error('Fetch error:', error);
        }
    }
    
    // Function to build and display the HTML for the issue cards.
    function renderIssueCards(issues) {
        issuesListContainer.innerHTML = ''; // Clear the "Loading..." message.
        if (!issues || issues.length === 0) {
            issuesListContainer.innerHTML = '<p>No issues found in this area. Be the first to <a href="report.php">report one</a>!</p>';
            return;
        }

        issues.forEach(issue => {
            const locationText = issue.distance ? `${Math.round(issue.distance * 10) / 10} km away` : issue.username;
            const imageSrc = issue.photo_path ? `/civiclink-api/${issue.photo_path}` : '/civiclink-api/assets/images/default-placeholder.png';
            const statusClass = getStatusClass(issue.status);
            const statusText = issue.status ? issue.status.charAt(0).toUpperCase() + issue.status.slice(1) : 'Open';
            const date = new Date(issue.created_at).toLocaleDateString('en-US', { day: 'numeric', month: 'long' });
            const detailUrl = `/civiclink-api/includes/issue_detail.php?id=${issue.id}`;

            // Create a <div> for the card and store the detail URL in a data attribute.
            const cardHtml = `
                <div class="issue-card" data-lat="${issue.location_lat}" data-lng="${issue.location_lng}" data-url="${detailUrl}">
                    <img src="${imageSrc}" alt="Issue Image" class="issue-card-img">
                    <div class="issue-card-content">
                        <div class="card-top-row">
                            <h3 class="card-title">${issue.title}</h3>
                            <span class="card-status ${statusClass}">${statusText}</span>
                        </div>
                        <div class="card-meta">
                            <!-- SVG for location icon -->
                            <span>${locationText}</span>
                        </div>
                        <a href="${detailUrl}" class="card-details-link">View Details →</a>
                    </div>
                </div>
            `;
            issuesListContainer.insertAdjacentHTML('beforeend', cardHtml);
        });
    }

    // Function to plot the colored dots on the map.
    function plotIssuesOnMap(issues) {
        // Clear any old markers first.
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
    }
    
    // Function to add the intelligent click listeners to the cards.
    function addCardClickListeners() {
        document.querySelectorAll('.issue-card').forEach(card => {
            card.addEventListener('click', function(event) {
                // If the user clicked the "View Details" link, do nothing and let the link work.
                if (event.target.classList.contains('card-details-link')) {
                    return;
                }
                
                // Otherwise, prevent any default action and take control.
                event.preventDefault();

                const lat = this.dataset.lat;
                const lng = this.dataset.lng;
                const url = this.dataset.url;

                if (window.innerWidth >= 992) {
                    // On Desktop: Pan the map.
                    if (lat && lng) {
                        map.flyTo([lat, lng], 15);
                    }
                } else {
                    // On Mobile: Go to the detail page.
                    if (url) {
                        window.location.href = url;
                    }
                }
            });
        });
    }

    // Function that starts the whole process.
    function initialize() {
        if ('geolocation' in navigator) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    map.setView([userLat, userLng], 13);
                     setTimeout(() => map.invalidateSize(), 100);
                    loadIssues(userLat, userLng);
                },
                () => {
                    console.warn("User denied location. Loading default view.");
                    loadIssues(null, null); // Load without location data
                }
            );
        } else {
            console.log('Geolocation not available. Loading default view.');
            loadIssues(null, null); // Load without location data
        }
    }
    
    // --- 4. START THE APP ---
    // This is the only function that runs automatically when the script loads.
    initialize();
});