<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$total_pages = $pdo->query('SELECT COUNT(*) FROM accounts')->fetchColumn();
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 5;
if ($stmt = $pdo->prepare('SELECT * FROM accounts ORDER BY id LIMIT :calc_page, :num_results_on_page')) {
    $stmt->bindValue(':calc_page', ($page - 1) * $num_results_on_page, PDO::PARAM_INT);
    $stmt->bindValue(':num_results_on_page', $num_results_on_page, PDO::PARAM_INT);
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    template_header('Read')
    ?>

    <div class="content read">
        <h2>Zarządzaj użytkownikami</h2>
        <a href="../test/register.html" class="create-contact"><i class="fa-solid fa-plus"></i> Stwórz użytkownika</a>
        <table>
            <thead>
            <tr>
                <td>#</td>
                <td>Nazwa użytkownika</td>
                <td>Email</td>
                <td>Hasło</td>
                <td>Admin</td>
                <td>Akcja</td>
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
                    <td class="actions">
                        <a href="update.php?id=<?= $contact['id'] ?>" class="edit"><i class="fas fa-pen fa-xs"> </i></a>
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