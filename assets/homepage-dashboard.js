document.addEventListener('DOMContentLoaded', function () {
    
    // --- 1. ELEMENT SELECTORS ---
    // Get references to all the dynamic parts of your homepage.
    const homepageMapElement = document.getElementById('homepageMap');
    const activityList = document.getElementById('activity-list');
    const contributorsGrid = document.getElementById('contributors-grid');

    // --- 2. INTERSECTION OBSERVER FOR THE MAP (THE MAIN FIX) ---
    
    // This observer will watch the map container.
    const mapObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            // isIntersecting is true when the element comes into the viewport.
            if (entry.isIntersecting) {
                // The map is now visible on the screen, so it's safe to initialize it.
                initializeLiveDashboard(homepageMapElement, activityList);
                
                // We only need to do this once. Stop watching the element.
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1 // Trigger when 10% of the map is visible.
    });

    // If the map element exists, tell the observer to start watching it.
    if (homepageMapElement) {
        mapObserver.observe(homepageMapElement);
    }
    
    // --- 3. INITIALIZE OTHER DYNAMIC SECTIONS ---

    // The Top Contributors section can load right away, as it doesn't have the same rendering issue.
    if (contributorsGrid) {
        loadTopContributors(contributorsGrid);
    }

});


// --- 4. FUNCTION DEFINITIONS ---
// These functions are now called by our initial setup logic.

/**
 * Initializes the Leaflet map and starts loading the issue data.
 * This function is ONLY called when the Intersection Observer sees the map.
 */
function initializeLiveDashboard(mapElement, listElement) {
    // Safety check: if the map has already been initialized, do nothing.
    if (mapElement._leaflet_id) {
        return;
    }

    const homepageMap = L.map(mapElement, { 
        zoomControl: true, 
        scrollWheelZoom: true,
        dragging: true,
        touchZoom: true
    }).setView([13.3439, 74.7475], 4.5);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_nolabels/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; CARTO',
    }).addTo(homepageMap);
    
    // Because this function runs only when the container is visible,
    // a simple invalidateSize call is now extremely effective.
    setTimeout(() => homepageMap.invalidateSize(), 1);

    // Now that the map is ready, fetch the data.
    loadHomepageIssues(homepageMap, listElement);
}

// Helper function for map pin colors
function getCategoryColor(category) {
    category = (category || '').toLowerCase();
    if (category.includes('road')) return '#3B82F6';
    if (category.includes('safety') || category.includes('electric')) return '#F59E0B';
    if (category.includes('park') || category.includes('vandalism') || category.includes('waste')) return '#10B981';
    return '#6B7280';
}

// Helper function for status badge CSS classes
function getStatusClass(status) {
    status = (status || 'open').toLowerCase();
    if (status === 'under review') return 'status-review';
    if (status === 'resolved') return 'status-resolved';
    return 'status-open';
}

// Fetches and displays the 5 most recent issues on the map and in the list
async function loadHomepageIssues(mapInstance, listElement) {
    try {
        const response = await fetch('/civiclink-api/handlers/homepage_handler.php');
        if (!response.ok) throw new Error('Network response failed for homepage issues');
        const issues = await response.json();

        listElement.innerHTML = '';

        if (issues.length === 0) {
            listElement.innerHTML = '<p style="padding: 10px;">No recent activity to show.</p>';
            return;
        }

        issues.forEach(issue => {
            const imageSrc = issue.photo_path ? `/civiclink-api/${issue.photo_path}` : '/civiclink-api/assets/images/default-placeholder.png';
            const statusClass = getStatusClass(issue.status);
            const statusText = (issue.status || 'Open').charAt(0).toUpperCase() + (issue.status || 'Open').slice(1);
            
            const cardHtml = `
                <div class="activity-card">
                    <img src="${imageSrc}" alt="Issue thumbnail" class="activity-card-img">
                    <div class="activity-card-info">
                        <h5>${issue.title}</h5>
                        <p>${issue.username} &bull; ${new Date(issue.created_at).toLocaleDateString()}</p>
                    </div>
                    <span class="card-status ${statusClass}">${statusText}</span>
                </div>`;
            listElement.insertAdjacentHTML('beforeend', cardHtml);

            // Add corresponding pin to the map
            const dotColor = getCategoryColor(issue.category);
            L.circleMarker([issue.location_lat, issue.location_lng], {
                radius: 7, fillColor: dotColor, color: '#fff', weight: 2, fillOpacity: 0.9
            }).addTo(mapInstance).bindPopup(`<b>${issue.title}</b>`);
        });

    } catch (error) {
        listElement.innerHTML = '<p style="padding: 10px;">Could not load recent activity.</p>';
        console.error("Failed to load homepage issues:", error);
    }
}

// Fetches and displays the top 5 contributors
async function loadTopContributors(gridElement) {
    try {
        const response = await fetch('/civiclink-api/handlers/top_contributors_handler.php');
        if (!response.ok) throw new Error('Network response failed for contributors');
        const contributors = await response.json();

        gridElement.innerHTML = '';

        if (contributors.length === 0) {
            gridElement.innerHTML = '<p>No contributions have been recorded yet.</p>';
            return;
        }

        contributors.forEach((contributor, index) => {
            const rank = index + 1;
            const firstLetter = contributor.username.charAt(0).toUpperCase();
            const cardHtml = `
                <div class="contributor-card">
                    <div class="contributor-rank">#${rank}</div>
                    <div class="contributor-avatar">${firstLetter}</div>
                    <h4 class="contributor-name">${contributor.username}</h4>
                    <p class="contributor-reports"><strong>${contributor.report_count}</strong> Reports</p>
                </div>`;
            gridElement.insertAdjacentHTML('beforeend', cardHtml);
        });

    } catch (error) {
        gridElement.innerHTML = '<p>Could not load contributors.</p>';
        console.error("Failed to load top contributors:", error);
    }
}