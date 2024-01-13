<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dodaj artykuł</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link href="comm/comments.css" rel="stylesheet" type="text/css">
</head>
<?php
include('functions.php');
$pdo = pdo_connect_mysql();
if(isset($_REQUEST['submit']))
{
    $content = $_REQUEST['content'];

    $insert_query = mysqli_query($connection, "insert into tbl_ckeditor set content='$content'");
    $stmt = $pdo->prepare('INSERT INTO article set  ');
    if($insert_query)
    {
        $msg = "Data Inserted";
    }
    else
    {
        $msg = "Error";
    }
}
?>
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
            <!--            <h2>This is Aside</h2>-->
            <!--            <p>This is side content</p>-->
            <!--            <ul>-->
            <!--                <li>author information</li>-->
            <!--                <li>fun facts</li>-->
            <!--                <li>quotes</li>-->
            <!--                <li>external links</li>-->
            <!--                <li>comments</li>-->
            <!--                <li>related content</li>-->
            <!--            </ul>-->
        </aside>

        <div class="contents">
            <h1>Classic editor</h1>
<!--            <div id="editor">-->
<!--                <p>This is some sample content.</p>-->
<!--            </div>-->
            <form method="post">
                <div class="form-group">
                    <textarea id="content" name="content" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Save" class="btn btn-primary">
                </div>
            </form>
            <div class="error"><?php if(!empty($msg)){ echo $msg; } ?></div>


        </div>

    </main>

    <footer>
        <p>Autor xyz</p>
    </footer>

</div>

</body>
</html>
<!--<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>-->
<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/translations/pl.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'),{
            language: 'pl'

    })
        .catch(error => {
            console.error(error);
        });
</script>
