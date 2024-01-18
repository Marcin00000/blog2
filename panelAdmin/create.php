<?php
////include 'functions.php';
//$pdo = pdo_connect_mysql();
//$msg = '';
//// Check if POST data is not empty
//if (!empty($_POST)) {
//    // Post data not empty insert a new record
//    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
//    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
//    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
//    $name = isset($_POST['name']) ? $_POST['name'] : '';
//    $email = isset($_POST['email']) ? $_POST['email'] : '';
//    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
//    $title = isset($_POST['title']) ? $_POST['title'] : '';
//    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
//    // Insert new record into the contacts table
//    $stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?, ?)');
//    $stmt->execute([$id, $name, $email, $phone, $title, $created]);
//    // Output message
//    $msg = 'Created Successfully!';
//}
//?>
<?php
include 'functions.php';

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
            header("Location: readArticle.php");
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

<?=template_header('Create')?>

<div class="content update">
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

<?=template_footer()?>

<script src="../ckeditor/ckeditor.js"></script>
<script src="../ckeditor/translations/pl.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'), {
            // language: 'pl'
            ckfinder:
                {
                    uploadUrl: '../fileupload.php'
                }

        })
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>