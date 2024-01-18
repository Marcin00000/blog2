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

<?= template_head('Artykuły') ?>

<body>
<div class="container">

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

<!--            --><?php
//            //            dupa
//            // connect to database
//            try {
//                $con = mysqli_connect('localhost', 'root', '');
//                mysqli_select_db($con, 'blog');
//                // define how many results you want per page
//                $results_per_page = 6;
//
//
//                // find out the number of results stored in database
//                $sql = 'SELECT * FROM article ';
//                $result = mysqli_query($con, $sql);
//                $number_of_results = mysqli_num_rows($result);
//
//                // determine number of total pages available
//                $number_of_pages = ceil($number_of_results / $results_per_page);
//
//                // determine which page number visitor is currently on
//                if (!isset($_GET['page'])) {
//                    $page = 1;
//                } else {
//                    $page = $_GET['page'];
//                }
//
//                // determine the sql LIMIT starting number for the results on the displaying page
//                $this_page_first_result = ($page - 1) * $results_per_page;
//
//                // retrieve selected results from database and display them on page
//                $sql = 'SELECT * FROM unique_article_entry_view LIMIT ' . $this_page_first_result . ',' . $results_per_page;
//                $result = mysqli_query($con, $sql);
//
//                while ($row = mysqli_fetch_array($result)) {
//                    echo "<article>" . "<h2>" . $row['title'] . "</h2>" . "<p>" . $row['text'] . "</p>" . '</article>';
//                }
//
//                echo '<div class="pag">';
//                // display the links to the pages
//                for ($page = 1; $page <= $number_of_pages; $page++) {
//                    echo '<a href="index2.php?page=' . $page . '">' . $page . '</a> ';
//                }
//                echo '</div>';
//            } catch (Exception $e) {
//                echo 'Wystąpił wyjątek nr ' . $e->getCode() . ', jego komunikat to:
//                ' . $e->getMessage();
//            }
//
//
//            ?>

            <?php

            // connect to database
            try {
                $con = mysqli_connect('localhost', 'root', '');
                mysqli_select_db($con, 'blog');
                // define how many results you want per page
                $results_per_page = 6;

                // find out the number of results stored in the database
                $sql = 'SELECT * FROM articles ';
                $result = mysqli_query($con, $sql);
                $number_of_results = mysqli_num_rows($result);

                // determine the number of total pages available
                $number_of_pages = ceil($number_of_results / $results_per_page);

                // determine which page number the visitor is currently on
                if (!isset($_GET['page'])) {
                    $page = 1;
                } else {
                    $page = $_GET['page'];
                }

                // determine the SQL LIMIT starting number for the results on the displaying page
                $this_page_first_result = ($page - 1) * $results_per_page;

                // retrieve selected results from the database and display them on the page
                $sql = 'SELECT * FROM articles ORDER BY id DESC LIMIT ' . $this_page_first_result . ',' . $results_per_page;
                $result = mysqli_query($con, $sql);

                while ($row = mysqli_fetch_array($result)) {
                    // Add a link to each article
                    echo "<article class='wpis'>";
                    echo "<h2><a href='article.php?id=" . $row['id'] . "'>" . $row['title'] . "</a></h2>";
                    echo "<p>" . $row['content'] . "</p>";
                    echo '</article>';
                }

                echo '<div class="pag">';
                // display the links to the pages
                for ($page = 1; $page <= $number_of_pages; $page++) {
                    echo '<a href="index2.php?page=' . $page . '">' . $page . '</a> ';
                }
                echo '</div>';
                mysqli_close($con);
            } catch (Exception $e) {
                echo 'Wystąpił wyjątek nr ' . $e->getCode() . ', jego komunikat to:
    ' . $e->getMessage();
            }
            ?>

        </div>

    </main>

    <?= template_foot() ?>

</div>

</body>
</html>