document.addEventListener('DOMContentLoaded', function () {
    const homepageMap = L.map('homepageMap', { zoomControl: false }).setView([20.5937, 78.9629], 5);
    const activityList = document.getElementById('activity-list');

    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_nolabels/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; CARTO',
    }).addTo(map);

    function getCategoryColor(category) {
        category = (category || '').toLowerCase();
        if (category.includes('road')) return '#3B82F6'; // Blue
        if (category.includes('safety') || category.includes('electric')) return '#F59E0B'; // Amber
        if (category.includes('park') || category.includes('vandalism') || category.includes('waste')) return '#10B981'; // Green
        return '#6B7280'; // Gray
    }

    function getStatusClass(status) {
        status = (status || 'open').toLowerCase();
        if (status === 'under review') return 'status-review';
        if (status === 'resolved') return 'status-resolved';
        return 'status-open';
    }

    async function loadHomepageIssues() {
        try {
            const response = await fetch('/civiclink-api/handlers/homepage_handler.php');
            if (!response.ok) throw new Error('Network response failed');
            const issues = await response.json();

            // Clear loading messages
            activityList.innerHTML = '';

            // Populate Recent Activity Feed
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
                activityList.insertAdjacentHTML('beforeend', cardHtml);

                // Add pins to the map
                const dotColor = getCategoryColor(issue.category);
                L.circleMarker([issue.location_lat, issue.location_lng], {
                    radius: 7,
                    fillColor: dotColor,
                    color: '#fff',
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.9
                }).addTo(homepageMap).bindPopup(`<b>${issue.title}</b>`);
            });

        } catch (error) {
            activityList.innerHTML = '<p>Could not load recent activity.</p>';
            console.error("Failed to load homepage issues:", error);
        }
    }

    loadHomepageIssues();
});