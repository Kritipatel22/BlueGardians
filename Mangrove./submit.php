<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'] ?? '';
    $latitude = $_POST['latitude'] ?? '';
    $longitude = $_POST['longitude'] ?? '';
    $time = date("Y-m-d H:i:s");
    $points = 10;

    // Handle photo upload
    $photoPath = "";
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid("report_", true) . "." . $ext;
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
            $photoPath = "http://localhost/CommunityMangroveWatch/" . $targetFile;
        }
    }

    // Load existing reports
    $jsonFile = "reports.json";
    $reports = [];
    if (file_exists($jsonFile)) {
        $reports = json_decode(file_get_contents($jsonFile), true);
    }

    // Add new report
    $newReport = [
        "description" => $description,
        "latitude" => $latitude,
        "longitude" => $longitude,
        "photo" => $photoPath,
        "points" => $points,
        "time" => $time
    ];
    $reports[] = $newReport;

    // Save back to file
    file_put_contents($jsonFile, json_encode($reports, JSON_PRETTY_PRINT));

    // Show confirmation page
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
      <meta charset='UTF-8'>
      <title>Report Submitted</title>
      <style>
        body {
          font-family: 'Segoe UI', Arial, sans-serif;
          background: #f0f8f5;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          margin: 0;
        }
        .card {
          background: white;
          padding: 30px;
          border-radius: 16px;
          box-shadow: 0 6px 16px rgba(0,0,0,0.2);
          text-align: center;
          max-width: 400px;
        }
        h2 {
          color: #2e7d32;
          margin-bottom: 10px;
        }
        p {
          font-size: 1rem;
          margin: 8px 0;
        }
        a {
          display: inline-block;
          margin: 10px;
          padding: 10px 18px;
          border-radius: 8px;
          text-decoration: none;
          font-weight: bold;
          transition: 0.3s ease;
        }
        .btn-report {
          background: #2e7d32;
          color: white;
        }
        .btn-report:hover {
          background: #256629;
        }
        .btn-dashboard {
          background: #4caf50;
          color: white;
        }
        .btn-dashboard:hover {
          background: #3b8c40;
        }
      </style>
    </head>
    <body>
      <div class='card'>
        <h2>✅ Report Submitted!</h2>
        <p>Thank you for protecting mangroves 🌱</p>
        <p>You earned <strong>$points points</strong>.</p>
        <a href='report.html' class='btn-report'>📸 Report Another</a>
        <a href='dashboard.php' class='btn-dashboard'>📊 View Dashboard</a>
      </div>
    </body>
    </html>
    ";
    exit;
}
?>
