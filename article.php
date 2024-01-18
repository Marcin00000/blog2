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

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link href="comm/comments.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="fontawesome6.5.1-web/css/all.css">
</head>
<body>
<div class="container">

    <?= template_nav() ?>

    <main>
        <aside>
        </aside>

        <div class="contents">

            <?php
            try {
                $con = mysqli_connect('localhost', 'root', '');
                mysqli_select_db($con, 'blog');

                // determine which page number visitor is currently on
                if (!isset($_GET['id'])) {
                    $id = 1;
                } else {
                    $id = $_GET['id'];
                }
                $comment_id = $id;

                // retrieve selected results from database and display them on page
                $sql = 'SELECT * FROM articles where id = ' . $id;
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($result);
                $sql2 = 'SELECT * FROM accounts where id = ' . $row['autor'];
                $result2 = mysqli_query($con, $sql2);
                $row2 = mysqli_fetch_array($result2);

                echo "<article>";
                echo "<h2>" . $row['title'] . "</h2>";

                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<p>" . $row['content'] . "</p>";
                }
                echo "Autor: " . $row2['username']."(". $row2['id'].")";
                echo '</article>';

                echo "<div class='button-container'>";
                echo "<a href='updatearticle.php?id=" . $id . "'><button class='bn632-hover bn22'><i class='fas fa-pen fa-xs'></i>  Edytuj</button></a>" ;
                echo "<a href='delarticle.php?id=" . $id . "'><button class='bn632-hover bn27'><i class='fas fa-trash fa-xs'></i>   Usuń</button></a>" ;
                echo "</div>";

                mysqli_close($con);

            } catch (Exception $e) {
                echo 'Wystąpił wyjątek nr ' . $e->getCode() . ', jego komunikat to:
                        ' . $e->getMessage();
            }

            ?>

            <div class="comments"></div>

            <script>
                const comments_page_id = <?=$comment_id?>; // This number should be unique on every page
                fetch("comm/comments.php?page_id=" + comments_page_id).then(response => response.text()).then(data => {
                    document.querySelector(".comments").innerHTML = data;
                    document.querySelectorAll(".comments .write_comment_btn, .comments .reply_comment_btn").forEach(element => {
                        element.onclick = event => {
                            event.preventDefault();
                            document.querySelectorAll(".comments .write_comment").forEach(element => element.style.display = 'none');
                            document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "']").style.display = 'block';
                            document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "'] input[name='name']").focus();
                        };
                    });
                    document.querySelectorAll(".comments .write_comment form").forEach(element => {
                        element.onsubmit = event => {
                            event.preventDefault();
                            fetch("comm/comments.php?page_id=" + comments_page_id, {
                                method: 'POST',
                                body: new FormData(element)
                            }).then(response => response.text()).then(data => {
                                element.parentElement.innerHTML = data;
                            });
                        };
                    });
                });
            </script>

        </div>

    </main>

    <?= template_foot() ?>

</div>

</body>
</html>