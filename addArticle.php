<?php
include 'functions.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: test\login.html');
    exit;
}
?>

<?= template_head('Dodaj artykuł') ?>
<style>
    .contents{
        background-color: #f2e9e4;
    }
</style>

<?php
try {
    $pdo = pdo_connect_mysql();
    $msg = '';

    $categories_query = "SELECT id, category FROM category";
    $categories_statement = $pdo->prepare($categories_query);
    $categories_statement->execute();

    $categories = $categories_statement->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_REQUEST['submit'])) {
        if (!empty($_POST['content'])) {
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $content = $_POST['content'];
            $category = $_POST['category'];
            $id = '';
            $autor = $_SESSION['id'];
            $date = date('Y-m-d H:i:s');
            $stmt = $pdo->prepare('INSERT INTO articles VALUES (?, ?,?,?,?,?)');
            $stmt->execute([$id, $title, $content, $autor, $date,$category]);
            $msg = 'Created Successfully!';
            header("Location: index2.php");
            exit();

        } else {
            $msg = 'Błąd danych';
        }
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
            <h1>Dodawanie wpisu | autor: <?= $_SESSION['name'] ?></h1>
            <form method="post">
                <div class="form-group">
                    <label for="title">Tytuł</label>
                    <input type="text" name="title" placeholder="Tytuł wpisu" id="title" required>

                    <textarea id="content" name="content" class="form-control" placeholder="Treść wpisu" ></textarea>
                </div>
                <br>
                <div class="form-group">
                    <label for="category">Kategoria</label>
                    <select id="category" name="category" class="form-control">
                        <?php
                        foreach ($categories as $category) {
                            echo "<option value=\"{$category['id']}\">{$category['category']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Zapisz" class="bn632-hover bn25">
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