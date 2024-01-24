
<?php
include 'functions.php';
// Your PHP code here.
session_start();
// If the user is not logged in redirect to the login page...
//if (!isset($_SESSION['loggedin'])) {
if (!($_SESSION['admin'])) {
    echo $_SESSION['admin'];
    header('Location: test\login.html');
    exit;
}
// Home Page template below.
?>

<?=template_header('Home')?>

    <div class="content">
        <h2>Strona główna</h2>
       <?=  $_SESSION['admin']; ?>
        <p>Witamy na stronie głównej!</p>
    </div>

<?=template_footer()?>