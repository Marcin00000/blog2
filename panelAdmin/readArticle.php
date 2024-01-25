<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$total_pages = $pdo->query('SELECT COUNT(*) FROM articles')->fetchColumn();
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 5;
if ($stmt = $pdo->prepare('SELECT * FROM articles ORDER BY id LIMIT :calc_page, :num_results_on_page')) {
    $stmt->bindValue(':calc_page', ($page - 1) * $num_results_on_page, PDO::PARAM_INT);
    $stmt->bindValue(':num_results_on_page', $num_results_on_page, PDO::PARAM_INT);
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    template_header('Read')
    ?>
    <div class="content read">
        <h2>Zarządzaj  artykułami</h2>
        <a href="../addArticle.php" class="create-contact"><i class="fa-solid fa-plus"></i> Stwórz artykuł</a>
        <table>
            <thead>
            <tr>
                <td>#</td>
                <td>Tytuł</td>
                <td>Autor</td>
                <td>Data</td>
                <td>Akcja</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?php echo "<a href='../article.php?id=" . $contact['id'] . "'>" . $contact['id'] . "</a>";?></td>
                    <td><?= $contact['title'] ?></td>
                    <td><?= $contact['autor'] ?></td>
                    <td><?= $contact['data'] ?></td>
                    <td class="actions">
                        <a href="../updateArticle.php?id=<?= $contact['id'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="deleteArticle.php?id=<?= $contact['id'] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="prev"><a href="readArticle.php?page=<?php echo $page-1 ?>">Prev</a></li>
                    <?php endif; ?>

                    <?php if ($page > 3): ?>
                        <li class="start"><a href="readArticle.php?page=1">1</a></li>
                        <li class="dots">...</li>
                    <?php endif; ?>

                    <?php if ($page-2 > 0): ?><li class="page"><a href="readArticle.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                    <?php if ($page-1 > 0): ?><li class="page"><a href="readArticle.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                    <li class="currentpage"><a href="readArticle.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                    <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="readArticle.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                    <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="readArticle.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                        <li class="dots">...</li>
                        <li class="end"><a href="readArticle.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                        <li class="next"><a href="readArticle.php?page=<?php echo $page+1 ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
    <?= template_footer() ?>
    <?php
}
?>