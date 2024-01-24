<?php
session_start();
// Połącz z bazą danych (ustaw odpowiednie dane dostępowe)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdź połączenie
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Odbierz dane od klienta
$playerName = isset($_SESSION['name']) ? $_SESSION['name'] : 'Anonim2';;
$moves = $_POST["moves"];
$matches = $_POST["matches"];
$boardSize = $_POST["boardSize"];

// Przygotuj zapytanie SQL
$sql = "INSERT INTO game (player ,moves, matches, board_size) VALUES ('$playerName','$moves', '$matches', '$boardSize')";

// Wykonaj zapytanie i sprawdź czy się udało
if ($conn->query($sql) === TRUE) {
    echo "Game results saved successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Zamknij połączenie
$conn->close();
?>
