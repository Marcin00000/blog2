<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Strona główna</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../fontawesome6.5.1-web/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body class="loggedin">
<nav class="navtop">
    <div>
        <h1>BLOG</h1>
        <a href="profile.php"><i class="fas fa-user-circle"></i>Profil</a>
        <a href="../index.php"><i class="fa-solid fa-house"></i>Blog</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Wyloguj</a>
        <?php
        if ($_SESSION['admin']){
            echo "<a href='../panelAdmin/index.php'>Panel administracyjny</a>";
        }
        ?>
    </div>
</nav>
<div class="content">
    <h2>Strona główna</h2>
    <p>Witamy z powrotem, <?= $_SESSION['name'] ?>!</p>
</div>
</body>
</html>
