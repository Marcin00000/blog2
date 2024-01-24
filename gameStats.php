<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$levels = [4, 6, 8];

foreach ($levels as $level) {
    echo "<div class='leaderboard-section'>";
    echo "<h2>Poziom $level x $level </h2>";

    $sql = "SELECT distinct player, moves, created_at FROM game WHERE board_size = $level ORDER BY moves ASC LIMIT 10";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='leaderboard-table'>";
            echo "<tr><th>Nazwa gracza</th><th>Ruchy</th><th>Data</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['player']}</td><td>{$row['moves']}</td><td>{$row['created_at']}</td></tr>";
        }
        echo "</table>";
    } else {
            echo "Brak zapisów na poziomie $level";
    }
    echo "</div>";
}
$conn->close();
?>