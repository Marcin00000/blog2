<?php
include 'functions.php';
session_start();

try {
$con = mysqli_connect('localhost', 'root', '');
mysqli_select_db($con, 'blog');
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$categories_query = "SELECT id, category FROM category";
$categories_result = $con->query($categories_query);

$categories = array();
while ($rowc = $categories_result->fetch_assoc()) {
    $categories[] = $rowc;
}
?>


<?= template_head('Artykuły') ?>

<body>
<div class="container">

    <?= template_nav() ?>

    <main>
        <aside>
            <form method="post">
                <div class="form-group">
                    <label for="category"><p><b>Wybierz kategorię</b></p></label>
                    <select id="category" name="category" class="form-control">
                        <?php
                        foreach ($categories as $category) {
                            echo "<option value=\"{$category['id']}\">{$category['category']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <input type="submit" name="submit" value="Wyślij" class="bn632-hover bn25">
                </div>
            </form>
        </aside>

        <div class="contents">


            <?php

            $selectedCategoryId = isset($_POST['category']) ? $_POST['category'] : 0;

            $results_per_page = 6;

            if ($selectedCategoryId != 0) {
                $sql = 'SELECT * FROM articles where category_id = ' . $selectedCategoryId;
            }
            else {
                $sql = 'SELECT * FROM articles';
            }
            $result = mysqli_query($con, $sql);
            $number_of_results = mysqli_num_rows($result);

            $number_of_pages = ceil($number_of_results / $results_per_page);

            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

                $this_page_first_result = ($page - 1) * $results_per_page;

            if ($selectedCategoryId != 0) {
                $sql = 'SELECT * FROM articles where category_id = ' . $selectedCategoryId . ' ORDER BY id DESC LIMIT ' . $this_page_first_result . ',' . $results_per_page;
                }
                else {
                    $sql = 'SELECT * FROM articles ORDER BY id DESC LIMIT ' . $this_page_first_result . ',' . $results_per_page;
                }
                $result = mysqli_query($con, $sql);

                while ($row = mysqli_fetch_array($result)) {
                    echo "<article class='wpis'>";
                    echo "<h2><a href='article.php?id=" . $row['id'] . "'>" . $row['title'] . "</a></h2>";
                    echo "<p>" . $row['content'] . "</p>";
                    echo '</article>';
                }
                echo '<div class="pag">';
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