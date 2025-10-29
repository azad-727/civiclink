document.addEventListener('DOMContentLoaded', function () {
    // --- SETUP ---
    const map = L.map('reportMap').setView([20.5937, 78.9629], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    let marker; // Variable to hold the single marker
    const latInput = document.getElementById('lat');
    const lngInput = document.getElementById('lng');
    const currentLocationBtn = document.getElementById('currentLocationBtn');

    // --- HELPER FUNCTION ---
    // This function is now the single source of truth for updating the location
    function updateLocation(lat, lng, zoomLevel = 15) {
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker([lat, lng]).addTo(map);
        latInput.value = lat;
        lngInput.value = lng;
        map.flyTo([lat, lng], zoomLevel);
    }

    // --- EVENT HANDLERS ---
    
    // 1. Handle Manual Map Click
    function onMapClick(e) {
        const coords = e.latlng;
        updateLocation(coords.lat, coords.lng);
    }

    // 2. Handle "Current Location" Button Click
    function getCurrentLocation() {
        if ('geolocation' in navigator) {
            currentLocationBtn.textContent = 'Getting Location...';
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    updateLocation(position.coords.latitude, position.coords.longitude);
                    // Restore original button text
                    currentLocationBtn.innerHTML = '<svg fill="none" ...>...</svg> Current Location';
                },
                (error) => {
                    alert(`Could not get location: ${error.message}`);
                    currentLocationBtn.innerHTML = '<svg fill="none" ...>...</svg> Current Location';
                }
            );
        } else {
            alert('Geolocation is not supported by your browser.');
        }
    }

    // --- NEW: GEOSEARCH SETUP ---
    
    // 3. Setup the Search Provider and Control
    const searchProvider = new GeoSearch.OpenStreetMapProvider();
    const searchControl = new GeoSearch.GeoSearchControl({
        provider: searchProvider,
        style: 'bar', // Use a search bar style
        showMarker: false, // We will handle the marker ourselves
        showPopup: false, // No popup
        autoClose: true, // Close results after selection
        searchLabel: 'Search for an address',
        keepResult: true, // Keep the address text in the search bar after selection
    });
    map.addControl(searchControl);

    // 4. Listen for the result of a search
    map.on('geosearch/showlocation', function (result) {
        // The 'result' object contains the location info
        // result.location.y is latitude, result.location.x is longitude
        updateLocation(result.location.y, result.location.x);
    });


    // --- BIND EVENTS ---
    map.on('click', onMapClick);
    currentLocationBtn.addEventListener('click', getCurrentLocation);

    // Minor fix: You will need to re-copy the SVG code inside the button's innerHTML in the getCurrentLocation function.
    // I've simplified it above for clarity.
});