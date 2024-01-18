<?php
include 'functions.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: test\login.html');
    exit;
}
?>

<?= template_head('Usuń artykuł') ?>

<?php
try {
//include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
$msg2 = '';
// Check that the contact ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM articles WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$article) {
        exit('Contact doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM articles WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Usunąłeś artykuł!';
            $msg2 = "<a href='index2.php'><button class='bn632-hover bn25'><i class='fa-solid fa-circle-left'></i> Powrót</button></a>";
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: index2.php');
            exit;
        }
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

            <h2>Usuń artykuł #<?=$article['id']?></h2>
            <?php if ($msg): ?>
                <p><?=$msg?></p>
                <p><?=$msg2?></p>
            <?php else: ?>
                <p>Czy na pewno chcesz usunąć artykuł #<?=$article['id']?>?</p>
                <div class="yesno">
                    <a href="delarticle.php?id=<?=$article['id']?>&confirm=yes"><button class='bn632-hover bn27'> <i class="fa-solid fa-check"></i>  Tak</button></a>
                    <a href="delarticle.php?id=<?=$article['id']?>&confirm=no"><button class='bn632-hover bn22'> <i class="fa-solid fa-xmark"></i> Nie</button></a>
                </div>
            <?php endif; ?>

        </div>

    </main>

    <?= template_foot() ?>

</div>

</body>
</html>