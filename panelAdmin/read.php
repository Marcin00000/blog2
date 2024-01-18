
<?php
// Below is optional, remove if you have already connected to your database.
//$mysqli = mysqli_connect('localhost', 'root', '', 'blog');
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Get the total number of records from our table "students".
$total_pages = $pdo->query('SELECT COUNT(*) FROM accounts')->fetchColumn();

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page.
$num_results_on_page = 5;

//if ($stmt = $mysqli->prepare('SELECT * FROM students ORDER BY name LIMIT ?,?')) {
if ($stmt = $pdo->prepare('SELECT * FROM accounts ORDER BY id LIMIT :calc_page, :num_results_on_page')) {
// Calculate the page to get the results we need from our table.
//$calc_page = ($page - 1) * $num_results_on_page;
    $stmt->bindValue(':calc_page', ($page - 1) * $num_results_on_page, PDO::PARAM_INT);
    $stmt->bindValue(':num_results_on_page', $num_results_on_page, PDO::PARAM_INT);

//$stmt->bindValue('ii', $calc_page, $num_results_on_page);
    $stmt->execute();
// Get the results...
//$result = $stmt->get_result();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <?= template_header('Read') ?>

    <div class="content read">
        <h2>Stwórz użytkownika</h2>
        <a href="../test/register.html" class="create-contact">Stwórz użytkownika</a>
        <table>
            <thead>
            <tr>
                <td>#</td>
                <td>Name</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Title</td>
                <td>Created</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= $contact['id'] ?></td>
                    <td><?= $contact['username'] ?></td>
                    <td><?= $contact['email'] ?></td>
                    <td><?= $contact['password'] ?></td>
                    <td><?= $contact['admin'] ?></td>
                    <td><?= $contact['admin'] ?></td>
                    <td class="actions">
                        <a href="update.php?id=<?= $contact['id'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="delete.php?id=<?= $contact['id'] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="prev"><a href="read.php?page=<?php echo $page-1 ?>">Prev</a></li>
                    <?php endif; ?>

                    <?php if ($page > 3): ?>
                        <li class="start"><a href="read.php?page=1">1</a></li>
                        <li class="dots">...</li>
                    <?php endif; ?>

                    <?php if ($page-2 > 0): ?><li class="page"><a href="read.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                    <?php if ($page-1 > 0): ?><li class="page"><a href="read.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                    <li class="currentpage"><a href="read.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                    <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="read.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                    <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="read.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                        <li class="dots">...</li>
                        <li class="end"><a href="read.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                        <li class="next"><a href="read.php?page=<?php echo $page+1 ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <?= template_footer() ?>

    <?php
}
?>