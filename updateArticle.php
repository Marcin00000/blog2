<?php
include 'functions.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: test\login.html');
    exit;
}
?>

<?= template_head('Aktualizuj artykuł') ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<?php
try {
    $pdo = pdo_connect_mysql();
    $msg = '';

    $categories_query = "SELECT id, category FROM category where id > 1";
    $categories_statement = $pdo->prepare($categories_query);
    $categories_statement->execute();
    $categories = $categories_statement->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_GET['id'])) {
        if (isset($_REQUEST['submit'])) {
            if (!empty($_POST['content'])) {
                $title = isset($_POST['title']) ? $_POST['title'] : '';
                $content = $_POST['content'];
                $id = $_GET['id'];
                $category = $_POST['category'];
                $autor = $_SESSION['id'];
                $date = date('Y-m-d H:i:s');
                $stmt = $pdo->prepare('UPDATE articles SET id = ?, title = ?, content = ?, autor = ?, data = ?, category_id = ? WHERE id = ?');
                $stmt->execute([$id, $title, $content, $autor, $date, $category, $_GET['id']]);
                $msg = 'Updated Successfully!';
                header("Location: index2.php");
                exit();

            } else {
                $msg = 'Błąd danych';
            }
        }
        $stmt = $pdo->prepare('SELECT * FROM articles WHERE id = ?');
        $stmt->execute([$_GET['id']]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$article) {
            exit('Contact doesn\'t exist with that ID!');
        }
    } else {
        exit('No ID specified!');
    }
} catch (Exception $e) {
    echo 'Wystąpił wyjątek nr ' . $e->getCode() . ', jego komunikat to:
                        ' . $e->getMessage();
}
?>
<body>
<div class="container">

    <?= template_nav() ?>

    <main>
        <aside>
        </aside>

        <div class="contents">
            <h1>Aktualizuj artykuł #<?= $article['id'] ?></h1>

            <form action="updateArticle.php?id=<?= $article['id'] ?>" method="post">
                <div class="form-group">
                    <label for="title">Tytuł</label>
                    <input type="text" name="title" placeholder="Tytuł wpisu" id="title"
                           value="<?= $article['title'] ?>" required>

                    <textarea id="content" name="content" class="form-control"
                              placeholder="Treść wpisu"><?= $article['content'] ?></textarea>
                </div>
                <br>
                <div class="form-group">
                    <label for="category">Kategoria</label>
                    <select id="category" name="category" class="form-control">
                        <?php
                        foreach ($categories as $category) {
                            $selected = ($category['id'] == $article['category_id']) ? 'selected' : '';
                            echo "<option value=\"{$category['id']}\" {$selected}>{$category['category']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <br>
                <div class="g-recaptcha" data-sitekey="6Le0c1spAAAAAKyQZQY8zUGc7elkCTJ6M1azCmlX"></div>
                <div class="form-group">
                    <input type="submit" id="dodaj" name="submit" value="Aktualizuj" class="bn632-hover bn25">
                </div>
            </form>
            <?php if ($msg): ?>
                <p><?= $msg ?></p>
            <?php endif; ?>


        </div>

    </main>

    <?= template_foot() ?>

</div>

</body>
</html>
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/translations/pl.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'), {
            language: 'pl',
            ckfinder:
                {
                    uploadUrl: 'fileupload.php'
                }

        })
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    $(document).on('click', '#dodaj', function () {

        var response = grecaptcha.getResponse();
        if (response.length == 0) {
            alert("Jesteś robotem!");
            return false;
        }
    })
</script>