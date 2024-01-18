<?php
include 'functions.php';
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: test\login.html');
    exit;
}
?>

<?= template_head('Home') ?>

<body>
<div class="container">
    <header>
        <h1>BLOG</h1>
    </header>

    <?= template_nav() ?>

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
                <p><?= $_SESSION['name'] ?></p>
                <ul>
                    <li>News Article</li>
                    <li>Job Post</li>
                    <li>Blog Post</li>
                </ul>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione quidem, repudiandae, suscipit illum
                    animi ullam omnis at laborum eaque dolorem aliquam quos iure cum deserunt asperiores facere sed
                    totam
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
                    animi ullam omnis at laborum eaque dolorem aliquam quos iure cum deserunt asperiores facere sed
                    totam
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
                    animi ullam omnis at laborum eaque dolorem aliquam quos iure cum deserunt asperiores facere sed
                    totam
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
                    animi ullam omnis at laborum eaque dolorem aliquam quos iure cum deserunt asperiores facere sed
                    totam
                    magni?</p>
            </article>

        </div>

    </main>

    <?= template_foot() ?>

</div>

</body>
</html>