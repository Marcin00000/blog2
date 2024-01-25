<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$playerName = $_GET["playerName"];
if (!empty($playerName)) {
    $sql = "SELECT player, moves, created_at, board_size FROM game WHERE player = '$playerName' ORDER BY moves ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<div class='leaderboard-section'>";
        echo "<h2>Statystyki graczy dla $playerName</h2>";
        echo "<table class='leaderboard-table'>";
        echo "<tr><th>Nazwa gracza</th><th>Ruchy</th><th>Data</th><th>Poziom</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['player']}</td><td>{$row['moves']}</td><td>{$row['created_at']}</td><td>{$row['board_size']}</td></tr>";
        }
        echo "</table></div>";
    } else {
        echo "No records found for player: $playerName";
    }
} else {
    echo "Player name not provided.";
}
$conn->close();
?>
<?php
