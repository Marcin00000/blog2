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

<?= template_head('Dodaj artykuł') ?>
<style>
    .contents{
        background-color: #f2e9e4;
    }
</style>

<?php
try {
//    include('functions.php');
    $pdo = pdo_connect_mysql();
    $msg = '';
    if (isset($_REQUEST['submit'])) {
        if (!empty($_POST['content'])) {
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $content = $_POST['content'];
            $id = '';
            $autor = $_SESSION['id'];
            $date = date('Y-m-d H:i:s');
            $stmt = $pdo->prepare('INSERT INTO articles VALUES (?, ?,?,?,?)');
            $stmt->execute([$id, $title, $content, $autor, $date]);
            $msg = 'Created Successfully!';
            header("Location: index2.php");
            exit();

        } else {
            $msg = 'Błąd danych';
//            header("Location: addArticle.php");
//            exit();
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
            <h1>Dodawanie wpisu | użytkownik > <?= $_SESSION['name'] ?></h1>
            <!--            <div id="editor">-->
            <!--                <p>This is some sample content.</p>-->
            <!--            </div>-->
            <form method="post">
                <div class="form-group">
                    <label for="title">Tytuł</label>
                    <input type="text" name="title" placeholder="Tytuł wpisu" id="title" required>

                    <textarea id="content" name="content" class="form-control" placeholder="Treść wpisu" ></textarea>
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
<!--<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>-->
<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/translations/pl.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'), {
            // language: 'pl'
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