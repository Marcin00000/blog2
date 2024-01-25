<?php
include 'functions.php';
session_start();
if (!($_SESSION['admin'])) {
    echo $_SESSION['admin'];
    header('Location: test\login.html');
    exit;
}
template_header('Home')
?>

    <div class="content">
        <h2>Strona główna</h2>
       <?=  $_SESSION['admin']; ?>
        <p>Witamy na stronie głównej!</p>
    </div>

<?=template_footer()?>