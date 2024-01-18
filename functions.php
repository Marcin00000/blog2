<?php
function pdo_connect_mysql()
{
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'blog';
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
        exit('Nie udało się połączyć z bazą danych!');
    }
}

function template_head($title)
{
    echo <<<EOT
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>$title</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="fontawesome6.5.1-web/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
EOT;
}

function template_nav()
{
    echo <<<EOT
<nav class="navbar">
    <ul>
        <li><a href="index.php"><i class='fa-solid fa-house'></i> Główna </a></li>
        <li><a href="index2.php"> <i class="fa-solid fa-book"></i> Artykuły </a></li>
<!--        <li><a href="index3.php">Oczko</a></li>-->
        <li><a href="addArticle.php"> <i class="fa-solid fa-pen-to-square"></i> Dodawanie </a></li>
        <li><a href="test/profile.php"> <i class="fa-solid fa-user"></i> Profile </a></li>

    </ul>
</nav>
EOT;
}

function template_foot()
{
    echo <<<EOT
    <footer>
        <p>Autor xyz</p>
    </footer>
EOT;
}

?>