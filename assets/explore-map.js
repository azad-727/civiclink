document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('exploreMap').setView([20.5937, 78.9629], 5);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_labels_under/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);

    // --- Geolocation Logic ---
    // This part runs first to get user location and reload the page for PHP
    const currentUrl = new URL(window.location.href);
    if (!currentUrl.searchParams.has('lat') && 'geolocation' in navigator) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;
                currentUrl.searchParams.set('lat', userLat);
                currentUrl.searchParams.set('lng', userLng);
                window.location.href = currentUrl.href;
            },
            () => { console.warn("User denied location access."); }
        );
    } else if (currentUrl.searchParams.has('lat')) {
        // If location is in URL, center the map there
        const userLat = parseFloat(currentUrl.searchParams.get('lat'));
        const userLng = parseFloat(currentUrl.searchParams.get('lng'));
        map.setView([userLat, userLng], 13);
    }
    
    // --- Plotting Issues Logic ---
    const issueCards = document.querySelectorAll('.issue-card');

    issueCards.forEach(card => {
        const lat = card.dataset.lat;
        const lng = card.dataset.lng;
        const status = card.querySelector('.card-status').textContent.trim().toLowerCase();
        
        let dotColor = '#3B82F6'; // Default (Open)
        if (status === 'under review') dotColor = '#F59E0B'; // Amber
        if (status === 'resolved') dotColor = '#10B981'; // Green

        if (lat && lng) {
            // Create a custom circle marker (heatmap dot)
            const circleMarker = L.circleMarker([lat, lng], {
                radius: 6,
                fillColor: dotColor,
                color: '#fff',
                weight: 1.5,
                opacity: 1,
                fillOpacity: 0.8
            }).addTo(map);

            const title = card.querySelector('.card-title').textContent;
            circleMarker.bindPopup(`<b>${title}</b><br>Status: ${status}`);

            // Link card click to map
            card.addEventListener('click', function() {
                map.flyTo([lat, lng], 15);
                circleMarker.openPopup();
            });
        }
    });
});