<?php
$users = [
    ["name" => "Ravi THE Mangrove Guardian 🌱", "points" => 50],
    ["name" => "Asha THE Carbon Defender 💨", "points" => 40],
    ["name" => "Kiran THE Climate Hero 🌍", "points" => 30],
    ["name" => "Volunteer Meera", "points" => 20],
    ["name" => "Captain Arjun", "points" => 15],
];

// Sort users by points (descending)
usort($users, function($a, $b) {
    return $b['points'] - $a['points'];
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Leaderboard - Community Mangrove Watch</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f8f5;
      text-align: center;
      padding: 30px;
    }
    h2 {
      color: #2e7d32;
    }
    table {
      margin: auto;
      border-collapse: collapse;
      width: 60%;
      background: white;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      border-radius: 12px;
      overflow: hidden;
    }
    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
    }
    th {
      background: #2e7d32;
      color: white;
    }
    tr:nth-child(2) td:first-child::after { content: " 🥇"; }
tr:nth-child(3) td:first-child::after { content: " 🥈"; }
tr:nth-child(4) td:first-child::after { content: " 🥉"; }

tr:nth-child(2) { background: #ffcc00; color: #000; font-weight: bold; }
tr:nth-child(3) { background: #c0c0c0; color: #000; font-weight: bold; }
tr:nth-child(4) { background: #cd7f32; color: #fff; font-weight: bold; }

  </style>
</head>
<body>
  <h2>🏆 Community Mangrove Watch Leaderboard</h2>
  <table>
    <tr>
      <th>Rank</th>
      <th>User</th>
      <th>Points</th>
    </tr>
    <?php $rank=1; foreach ($users as $u): ?>
      <tr>
        <td><?php echo $rank++; ?></td>
        <td><?php echo $u['name']; ?></td>
        <td><?php echo $u['points']; ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
  <p><a href="index.html">⬅ Back to Home</a></p>
</body>
</html>
