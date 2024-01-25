<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'blog';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Nie udało się połączyć z MySQL: ' . mysqli_connect_error());
}
if (!isset($_POST['username'], $_POST['password'])) {
    exit('Proszę wypełnić pola nazwy użytkownika i hasła!');
}
if ($stmt = $con->prepare('SELECT id, password, admin FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $admin);
        $stmt->fetch();
        if (password_verify($_POST['password'], $password)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            $_SESSION['admin'] = $admin;
            header('Location: home.php');
        } else {
            echo 'Nieprawidłowa nazwa użytkownika i/lub hasło!';
        }
    } else {
        echo 'Nieprawidłowa nazwa użytkownika i/lub hasło!';
    }
    $stmt->close();
}
?>

