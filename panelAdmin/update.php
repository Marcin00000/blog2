<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        $stmt = $pdo->prepare('UPDATE accounts SET id = ?, username = ?, password = ?, email = ?, admin = ?, created = ? WHERE id = ?');
        $stmt->execute([$id, $name, $email, $phone, $title, $created, $_GET['id']]);
        $msg = 'Updated Successfully!';
        header('Location: read.php');
        exit;
    }
    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<?=template_header('Read')?>

<div class="content update">
    <h2>Update Contact #<?=$contact['id']?></h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">
        <label for="id">ID</label>
        <label for="name">username</label>
        <input type="text" name="id" placeholder="1" value="<?=$contact['id']?>" id="id">
        <input type="text" name="name" placeholder="John Doe" value="<?=$contact['username']?>" id="name">
        <label for="email">password</label>
        <label for="phone">email</label>
        <input type="text" name="email" placeholder="johndoe@example.com" value="<?=$contact['password']?>" id="email">
        <input type="text" name="phone" placeholder="2025550143" value="<?=$contact['email']?>" id="phone">
        <label for="title">admin</label>
        <label for="created">Created</label>
        <input type="text" name="title" placeholder="Employee" value="<?=$contact['admin']?>" id="title">
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i', strtotime($contact['created']))?>" id="created">
        <br>
        <div class="g-recaptcha" data-sitekey="6Le0c1spAAAAAKyQZQY8zUGc7elkCTJ6M1azCmlX"></div>
        <br>
        <input type="submit" id="dodaj" value="Update">
    </form>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
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
