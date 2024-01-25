<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM articles WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Artykuł nie istnieje z takim ID!');
    }
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM articles WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Usunąłeś artykuł!';
        } else {
            header('Location: readArticle.php');
            exit;
        }
    }
} else {
    exit('Nie określono identyfikatora!');
}
?>

<?=template_header('Delete')?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="content delete">
    <h2>Usuń artykuł #<?=$contact['id']?></h2>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php else: ?>
        <p>Czy na pewno chcesz usunąć artykuł #<?=$contact['id']?>?</p>
        <br>
        <div class="g-recaptcha" data-sitekey="6Le0c1spAAAAAKyQZQY8zUGc7elkCTJ6M1azCmlX"></div>
        <br>
        <div class="yesno" id="dodaj">
            <a href="deleteArticle.php?id=<?=$contact['id']?>&confirm=yes">Tak</a>
            <a href="deleteArticle.php?id=<?=$contact['id']?>&confirm=no">Nie</a>
        </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
<script>
    $(document).on('click','#dodaj',function () {

        var response = grecaptcha.getResponse();
        if (response.length==0){
            alert("Jesteś robotem!");
            return false;
        }
    })
</script>
