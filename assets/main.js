// This function will run once the entire HTML document is loaded and ready.
document.addEventListener('DOMContentLoaded', function() {
    
    // --- MOBILE NAVIGATION TOGGLE ---
    const mobileMenu = document.getElementById('mobile-menu');
    const navLinks = document.getElementById('nav-links');

    // Check if the mobile menu element exists on the page
    if (mobileMenu && navLinks) {
        mobileMenu.addEventListener('click', () => {
            // Toggle the 'active' class to show/hide the mobile menu
            navLinks.classList.toggle('active');
        });
    }

    // --- PROFILE DROPDOWN MENU LOGIC ---
    const profileIcon = document.getElementById('profile-icon');
    const profileDropdown = document.getElementById('profile-dropdown');

    // Check if the profile icon exists (it only exists if the user is logged in)
    if (profileIcon && profileDropdown) {
        profileIcon.addEventListener('click', (event) => {
            // Prevent the link's default behavior (like navigating to '#')
            event.preventDefault();
            // Toggle the 'active' class to show/hide the dropdown
            profileDropdown.classList.toggle('active');
        });

        // Add a global click listener to close the dropdown if the user clicks outside of it
        document.addEventListener('click', (event) => {
            // If the click was NOT on the profile icon AND NOT inside the dropdown menu...
            if (!profileIcon.contains(event.target) && !profileDropdown.contains(event.target)) {
                // ...then remove the 'active' class to hide the dropdown.
                profileDropdown.classList.remove('active');
            }
        });
    }

    // You can add more site-wide JavaScript here in the future (e.g., for the search bar)

});