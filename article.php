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
</head>
<body>
<div class="container">
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="index2.php">Wpisy</a></li>
            <li><a href="index3.php">ToDo</a></li>
            <li><a href="index.php">ToDo</a></li>
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
                $sql = 'SELECT * FROM article_entry_view where id_article = ' . $id;
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($result);

                echo "<article>";
                echo "<h2>" . $row['title'] . "</h2>";

                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<p>" . $row['text'] . "</p>";
                }
                echo '</article>';

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

    <footer>
        <p>Autor xyz</p>
    </footer>

</div>

</body>
</html>