document.addEventListener('DOMContentLoaded', function () {
    
    // --- LIVE DASHBOARD INITIALIZATION ---
    const homepageMapElement = document.getElementById('homepageMap');
    const activityList = document.getElementById('activity-list');
    
    if (homepageMapElement && activityList) {
        const homepageMap = L.map('homepageMap', { zoomControl: false, scrollWheelZoom: false }).setView([20.5937, 78.9629], 5);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_nolabels/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; CARTO',
        }).addTo(homepageMap);
        
        loadHomepageIssues(homepageMap, activityList);
    }

    // --- TOP CONTRIBUTORS INITIALIZATION ---
    const contributorsGrid = document.getElementById('contributors-grid');
    if (contributorsGrid) {
        loadTopContributors(contributorsGrid);
    }

});

// --- FUNCTION DEFINITIONS ---

// Function to get color based on category for map pins
function getCategoryColor(category) {
    category = (category || '').toLowerCase();
    if (category.includes('road')) return '#3B82F6'; // Blue
    if (category.includes('safety') || category.includes('electric')) return '#F59E0B'; // Amber
    if (category.includes('park') || category.includes('vandalism') || category.includes('waste')) return '#10B981'; // Green
    return '#6B7280'; // Gray
}

// Function to get CSS class for status badges
function getStatusClass(status) {
    status = (status || 'open').toLowerCase();
    if (status === 'under review') return 'status-review';
    if (status === 'resolved') return 'status-resolved';
    return 'status-open';
}

// Fetches and displays the 5 most recent issues
async function loadHomepageIssues(mapInstance, listElement) {
    try {
        const response = await fetch('/civiclink-api/handlers/homepage_handler.php');
        if (!response.ok) throw new Error('Network response failed');
        const issues = await response.json();

        listElement.innerHTML = ''; // Clear "Loading..." message

        if (issues.length === 0) {
            listElement.innerHTML = '<p>No recent activity.</p>';
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

            // Add a pin to the map for this issue
            const dotColor = getCategoryColor(issue.category);
            L.circleMarker([issue.location_lat, issue.location_lng], {
                radius: 7, fillColor: dotColor, color: '#fff', weight: 2, fillOpacity: 0.9
            }).addTo(mapInstance).bindPopup(`<b>${issue.title}</b>`);
        });

    } catch (error) {
        listElement.innerHTML = '<p>Could not load recent activity.</p>';
        console.error("Failed to load homepage issues:", error);
    }
}

// Fetches and displays the top 5 contributors
async function loadTopContributors(gridElement) {
    try {
        const response = await fetch('/civiclink-api/handlers/top_contributors_handler.php');
        if (!response.ok) throw new Error('Network response failed');
        const contributors = await response.json();

        gridElement.innerHTML = ''; // Clear "Loading..." message

        if (contributors.length === 0) {
            gridElement.innerHTML = '<p>No contributions yet. Be the first!</p>';
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