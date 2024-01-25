<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Nie istnieje użytkownik o tym identyfikatorze!');
    }
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM accounts WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Usunąłeś użytkownika!';
        } else {
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('Nie określono identyfikatora!');
}
?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<?=template_header('Delete')?>

<div class="content delete">
    <h2>Usunąć użytkownika #<?=$contact['id']?></h2>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php else: ?>
        <p>Czy na pewno chcesz usunąć użytkownika #<?=$contact['id']?>?</p>
        <br>
        <div class="g-recaptcha" data-sitekey="6Le0c1spAAAAAKyQZQY8zUGc7elkCTJ6M1azCmlX"></div>
        <div class="yesno" id="dodaj">
            <a href="delete.php?id=<?=$contact['id']?>&confirm=yes">Tak</a>
            <a href="delete.php?id=<?=$contact['id']?>&confirm=no">Nie</a>
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
