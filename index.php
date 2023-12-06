<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: test\login.html');
    exit;
}
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
<header>
    <h1>BLOG</h1>
</header>

<nav class="navbar">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="index2.php">Wpisy</a></li>
        <li><a href="index3.php">Oczko</a></li>
        <li><a href="index.php">ToDo</a></li>
        <li><a href="test/profile.php">Profile</a></li>

    </ul>
</nav>

<main>
    <aside>
        <h2>This is Aside</h2>
        <p>This is side content</p>
        <ul>
            <li>author information</li>
            <li>fun facts</li>
            <li>quotes</li>
            <li>external links</li>
            <li>comments</li>
            <li>related content</li>
        </ul>
    </aside>

    <div class="contents">

        <article>
            <h2>Home Page</h2>
            <p><?=$_SESSION['name']?></p>
            <ul>
                <li>News Article</li>
                <li>Job Post</li>
                <li>Blog Post</li>
            </ul>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione quidem, repudiandae, suscipit illum
                animi ullam omnis at laborum eaque dolorem aliquam quos iure cum deserunt asperiores facere sed totam
                magni?</p>
        </article>

        <article>
            <h2>This is an Article</h2>
            <p>This is independent content</p>
            <ul>
                <li>News Article</li>
                <li>Job Post</li>
                <li>Blog Post</li>
            </ul>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione quidem, repudiandae, suscipit illum
                animi ullam omnis at laborum eaque dolorem aliquam quos iure cum deserunt asperiores facere sed totam
                magni?</p>
        </article>

        <article>
            <h2>This is an Article</h2>
            <p>This is independent content</p>
            <ul>
                <li>News Article</li>
                <li>Job Post</li>
                <li>Blog Post</li>
            </ul>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione quidem, repudiandae, suscipit illum
                animi ullam omnis at laborum eaque dolorem aliquam quos iure cum deserunt asperiores facere sed totam
                magni?</p>
        </article>

        <article>
            <h2>This is an Article</h2>
            <p>This is independent content</p>
            <ul>
                <li>News Article</li>
                <li>Job Post</li>
                <li>Blog Post</li>
            </ul>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione quidem, repudiandae, suscipit illum
                animi ullam omnis at laborum eaque dolorem aliquam quos iure cum deserunt asperiores facere sed totam
                magni?</p>
        </article>

    </div>

</main>

<footer>
    <p>Autor xyz</p>
</footer>

</div>

</body>
</html>