<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="index2.php">Wpisy</a></li>
            <li><a href="index.php">ToDo</a></li>
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

        <div class="content">

<!--            <article>-->
<!--                <h2>This is an test Article</h2>-->
<!--                <p>This is independent content</p>-->
<!--                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione quidem, repudiandae, suscipit illum-->
<!--                    animi ullam omnis at laborum eaque dolorem aliquam quos iure cum deserunt asperiores facere sed totam-->
<!--                    magni?</p>-->
<!--            </article>-->

            <?php

            // connect to database
            $con = mysqli_connect('localhost','root','');
            mysqli_select_db($con, 'blog');

            // define how many results you want per page
            $results_per_page = 6;

            // find out the number of results stored in database
            $sql='SELECT * FROM wpis';
            $result = mysqli_query($con, $sql);
            $number_of_results = mysqli_num_rows($result);

            // determine number of total pages available
            $number_of_pages = ceil($number_of_results/$results_per_page);

            // determine which page number visitor is currently on
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            // determine the sql LIMIT starting number for the results on the displaying page
            $this_page_first_result = ($page-1)*$results_per_page;

            // retrieve selected results from database and display them on page
            $sql='SELECT * FROM wpis LIMIT ' . $this_page_first_result . ',' .  $results_per_page;
            $result = mysqli_query($con, $sql);

            while($row = mysqli_fetch_array($result)) {
                echo "<article>" ."<h2>". $row['text'] . "</h2>"."<p>" . $row['wpis2']."</p>". '</article>';
            }

            echo '<div class="pag">';
            // display the links to the pages
            for ($page=1;$page<=$number_of_pages;$page++) {
                echo '<a href="index2.php?page=' . $page . '">' . $page . '</a> ';
            }
            echo '</div>';

            ?>

        </div>

    </main>

    <footer>
        <p>Autor xyz</p>
    </footer>

</div>

</body>
</html>