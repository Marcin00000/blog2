<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$playerName = isset($_SESSION['name']) ? $_SESSION['name'] : 'Anonim2';
$moves = $_POST["moves"];
$matches = $_POST["matches"];
$boardSize = $_POST["boardSize"];
$sql = "INSERT INTO game (player ,moves, matches, board_size) VALUES ('$playerName','$moves', '$matches', '$boardSize')";
if ($conn->query($sql) === TRUE) {
    echo "Game results saved successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
