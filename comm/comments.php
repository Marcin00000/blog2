<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'blog';
try {
    $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    exit('Nie udało się połączyć z bazą danych: ' . $exception->getMessage());
}
function delete_comment_recursively($pdo, $id) {
    $stmt = $pdo->prepare('DELETE FROM comments WHERE id = ?');
    $stmt->execute([$id]);

    $stmt = $pdo->prepare('SELECT * FROM comments WHERE parent_id = ?');
    $stmt->execute([$id]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($comments as $comment) {
        delete_comment_recursively($pdo, $comment['id']);
    }
}
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $w = floor($diff->d / 7);
    $diff->d -= $w * 7;
    $string = ['y' => 'year','m' => 'month','w' => 'week','d' => 'day','h' => 'hour','i' => 'minute','s' => 'second'];
    foreach ($string as $k => &$v) {
        if ($k == 'w' && $w) {
            $v = $w . ' week' . ($w > 1 ? 's' : '');
        } else if (isset($diff->$k) && $diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
function show_comments($comments, $parent_id = -1) {
    $html = '';
    if ($parent_id != -1) {
        array_multisort(array_column($comments, 'submit_date'), SORT_ASC, $comments);
    }
    foreach ($comments as $comment) {
        if ($comment['parent_id'] == $parent_id) {
            $html .= '
            <div class="comment">
                <div>
                    <h3 class="name">' . htmlspecialchars($comment['name'], ENT_QUOTES) . '</h3>
                    <span class="date">' . time_elapsed_string($comment['submit_date']) . '</span>
                </div>
                <p class="content">' . nl2br(htmlspecialchars($comment['content'], ENT_QUOTES)) . '</p>
                <a class="reply_comment_btn" href="#" data-comment-id="' . $comment['id'] . '">Odpowiedz</a>
                ' . show_write_comment_form($comment['id']) . '
                <div class="replies">
                ' . show_comments($comments, $comment['id']) . '
                </div>
            </div>
            ';
        }
    }
    return $html;
}
function show_write_comment_form($parent_id = -1) {
    $html = '
    <div class="write_comment" data-comment-id="' . $parent_id . '">
        <form>
            <input name="parent_id" type="hidden" value="' . $parent_id . '">
            <input name="name" type="text" placeholder="Twoje imię" required>
            <textarea name="content" placeholder="Napisz tutaj swój komentarz..." required></textarea>
            <button type="submit">Prześlij komentarz</button>
        </form>
    </div>
    ';
    return $html;
}
if (isset($_GET['page_id'])) {
    if (isset($_POST['name'], $_POST['content'])) {
        $stmt = $pdo->prepare('INSERT INTO comments (page_id, parent_id, name, content, submit_date) VALUES (?,?,?,?,NOW())');
        $stmt->execute([ $_GET['page_id'], $_POST['parent_id'], $_POST['name'], $_POST['content'] ]);
        exit('Twój komentarz został przesłany!');
    }
    $stmt = $pdo->prepare('SELECT * FROM comments WHERE page_id = ? ORDER BY submit_date DESC');
    $stmt->execute([ $_GET['page_id'] ]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare('SELECT COUNT(*) AS total_comments FROM comments WHERE page_id = ?');
    $stmt->execute([ $_GET['page_id'] ]);
    $comments_info = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    exit('Nie określono ID!');
}
?>
<div class="comment_header">
    <span class="total"><?=$comments_info['total_comments']?> comments</span>
    <a href="#" class="write_comment_btn" data-comment-id="-1">Napisz komentarz</a>
</div>

<?=show_write_comment_form()?>

<?=show_comments($comments)?>
