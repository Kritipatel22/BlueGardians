<?php
  $reports = json_decode(file_get_contents("reports.json"), true);

  // Sort reports by time (latest last)
  usort($reports, function($a, $b) {
    return strtotime($a['time']) - strtotime($b['time']);
  });

  // Get latest report
  $latestReport = end($reports);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Community Mangrove Watch</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Arial, sans-serif;
      background: #f0f8f5;
    }
    header {
      background: #2e7d32;
      color: white;
      text-align: center;
      padding: 15px;
      font-size: 1.5rem;
      font-weight: bold;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    #map {
      height: calc(100vh - 60px); /* full height minus header */
      width: 100%;
    }
    .popup-content {
      font-size: 0.9rem;
      max-width: 250px;
    }
    .popup-content img {
      width: 100%;
      max-height: 150px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 8px;
    }
    .popup-content h4 {
      margin: 5px 0;
      color: #2e7d32;
      font-size: 1rem;
    }
    .popup-content small {
      color: #666;
    }
  </style>
</head>
<body>
  <header>📊 Incident Dashboard (Map View)</header>
  <div id="map"></div>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    // Reports data from PHP
    var reports = <?php echo json_encode($reports); ?>;
    var latest = <?php echo json_encode($latestReport); ?>;

    // Initialize map, centered on the latest report
    var map = L.map('map').setView([latest.latitude, latest.longitude], 12);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Add all markers
    reports.forEach(function(report) {
      var marker = L.marker([report.latitude, report.longitude]).addTo(map);

      // Popup content
      var popupHtml = `
        <div class="popup-content">
          <img src="${report.photo}" alt="Report Photo">
          <h4>${report.description}</h4>
          <div><i class="fa-solid fa-location-dot"></i> Lat: ${report.latitude}, Lng: ${report.longitude}</div>
          <div><i class="fa-solid fa-star"></i> Points: ${report.points}</div>
          <small><i class="fa-regular fa-clock"></i> ${report.time}</small>
        </div>
      `;

      marker.bindPopup(popupHtml);
    });
  </script>
</body>
</html>
