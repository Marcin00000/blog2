<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'blog';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Nie udało się połączyć z MySQL: ' . mysqli_connect_error());
}
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    exit('Proszę wypełnić formularz rejestracyjny!');
}
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
    exit('Proszę wypełnić formularz rejestracyjny!');
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    exit('Adres e-mail jest nieprawidłowy!');
}
if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('Nazwa użytkownika jest nieprawidłowa!');
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
    exit('Hasło musi mieć od 5 do 20 znaków!');
}
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo 'Nazwa użytkownika istnieje. Wybierz inną!<a href="register.html">Wróć do rejestracji</a>';
    } else {
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
            $stmt->execute();
            $message = 'Zarejestrowałeś się pomyślnie! Możesz się teraz zalogować!';
            echo "<script type='text/javascript'>alert('$message');</script>";
            echo "<script>window.location.href='logout.php';</script>";
        } else {
            echo 'Nie można przygotować oświadczenia!';
        }
    }
    $stmt->close();
} else {
    echo 'Nie można przygotować oświadczenia!';
}
$con->close();
?>