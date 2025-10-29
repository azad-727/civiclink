# CivicLink - Community Issue Reporting Platform

## 1. Project Overview

CivicLink is a full-stack web application designed to bridge the gap between citizens and local authorities. It provides a user-friendly platform for reporting, viewing, and tracking local civic issues such as potholes, broken streetlights, and waste management problems. The application leverages geolocation to create a dynamic, map-based dashboard of "problem hotspots," helping both the community and officials to prioritize and resolve issues efficiently.

---

## 2. Key Features

*   **User Authentication:** Secure user registration, login, and session management.
*   **Dynamic User Profiles:** Users can view and edit their profile information.
*   **Issue Reporting:** An intuitive form allowing users to report issues with a title, description, category, and an optional photo upload.
*   **Interactive Geolocation:**
    *   Users can pin the exact location of an issue on a map.
    *   A "Use Current Location" feature automatically gets the user's GPS coordinates.
*   **Explore Dashboard:**
    *   Displays all reported issues on an interactive map with color-coded "hotspot" markers.
    *   Features a responsive, side-by-side list of issue cards.
    *   **Proximity Sorting:** Automatically detects the user's location and sorts the issue list to show the nearest problems first.
*   **Single Issue Detail Page:** A dedicated page for each issue, showing all details and photos.
*   **Community Verification System:** Logged-in users can "verify" an issue, increasing its visibility. The system prevents a user from verifying the same issue more than once.
*   **Personalized "My Contributions" Page:** Allows users to see a list of all the issues they have personally reported.
*   **Fully Responsive Design:** The UI is optimized for a seamless experience on both desktop and mobile devices.

---

## 3. Technology Stack

*   **Frontend:** HTML5, CSS3 (with Flexbox & Grid), Vanilla JavaScript (ES6+), Leaflet.js (for maps).
*   **Backend:** PHP
*   **Database:** MySQL
*   **Server Environment:** Apache (via XAMPP)

---

## 4. Setup and Installation

To run this project locally, please follow these steps:

1.  **Prerequisites:** Ensure you have [XAMPP](https://www.apachefriends.org/index.html) (or a similar AMP stack) installed and running.

2.  **Clone the Repository:** Place the project folder (`civiclink-api`) inside your XAMPP `htdocs` directory.
    - The final path should be `C:/xampp/htdocs/civiclink-api/`.

3.  **Start Services:** Open the XAMPP Control Panel and start the **Apache** and **MySQL** services.

4.  **Database Setup:**
    - Navigate to `http://localhost/phpmyadmin` in your browser.
    - Create a new database and name it **`civiclink_db`**.
    - Select the new database, go to the **"Import"** tab.
    - Click "Choose File" and select the `database.sql` file provided in this project.
    - Click "Go" at the bottom of the page to import the tables and structure.

5.  **Run the Application:**
    - Open your browser and navigate to **`http://localhost/civiclink-api/`**. The homepage should now be visible.