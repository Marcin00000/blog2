<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'blog';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions, so instead, we can get the results from the database.
$stmt = $con->prepare('SELECT password, email, admin FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $admin);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Strona profilu</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../fontawesome6.5.1-web/css/all.css">

    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">-->
</head>
<body class="loggedin">
<nav class="navtop">
    <div>
        <h1>BLOG</h1>
        <a href="../index.php"><i class="fa-solid fa-house"></i>Blog</a>
        <a href="profile.php"><i class="fas fa-user-circle"></i>Profil</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Wyloguj</a>
        <?php
        if ($_SESSION['admin']){
        echo "<a href='../panelAdmin/index.php'><i class='fa-solid fa-toolbox'></i>Panel administracyjny</a>";
        }
        ?>
    </div>
</nav>
<div class="content">
    <h2>Strona profilu</h2>
    <div>
        <p>Dane Twojego konta znajdują się poniżej:</p>
        <table>
            <tr>
                <td>Nazwa:</td>
                <td><?= $_SESSION['name'] ?></td>
            </tr>
            <tr>
                <td>Hasło:</td>
                <td><?= $password ?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?= $email ?></td>
            </tr>
            <tr>
                <td>Admin:</td>
                <td><?= $admin ?></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
