<?php
if ($_SERVER["REQUEST_METHOD"] != "GET" || !isset($_GET['id'])) {
    header("Location: ./");
    exit();
}

$title = 'Photofox - Post';
$currentPage = '';
require_once('nav.php');
require_once 'database.php';

// Post-ID aus der URL abrufen
$post_id = intval($_GET['id']);

if ($post_id <= 0) {
    die("Ungültige Post-ID.");
}

// Benutzer-ID aus der Session abrufen
$user_id = $_SESSION['user_id'];

// Den spezifischen Post sowie den User und zusätzliche Informationen abrufen
$post_stmt = $conn->prepare(
    'SELECT posts.*, users.username, users.profile_pic,
        (SELECT COUNT(*) FROM views WHERE user_id = ? AND post_id = posts.id) as view_count,
        (SELECT COUNT(*) FROM likes WHERE post_id = posts.id) as like_count,
        (SELECT COUNT(*) FROM likes WHERE user_id = ? AND post_id = posts.id) as user_like_count
    FROM posts
    JOIN users ON posts.user_id = users.id
    WHERE posts.id = ? AND allowed = TRUE'
);
$post_stmt->bind_param('iii', $user_id, $user_id, $post_id);
$post_stmt->execute();
$post = $post_stmt->get_result()->fetch_assoc();

if (!$post) {
    die("Post nicht gefunden.");
}

$insert_view_stmt = $conn->prepare(
    'INSERT INTO views (user_id, post_id)
    SELECT ?, ?
    WHERE NOT EXISTS (
        SELECT 1 FROM views WHERE user_id = ? AND post_id = ?
    )'
);
$insert_view_stmt->bind_param('iiii', $user_id, $post_id, $user_id, $post_id);
$insert_view_stmt->execute();

// Kommentare zu diesem Post abrufen
$comment_stmt = $conn->prepare(
    'SELECT comments.*, users.username, users.profile_pic
    FROM comments
    JOIN users ON comments.user_id = users.id
    WHERE comments.post_id = ? AND comments.allowed = 1
    ORDER BY comments.written_at ASC'
);
$comment_stmt->bind_param('i', $post_id);
$comment_stmt->execute();
$comments = $comment_stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$user_has_liked = ($post['user_like_count'] > 0);
$like_count = $post['like_count'];
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - PhotoFox</title>
    <link rel="stylesheet" href="./style/post.css">
    <style>
        .like-heart {
            cursor: pointer;
            width: 24px;
            height: 24px;
            background-repeat: no-repeat;
            background-size: contain;
            vertical-align: middle;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="post">
            <?php if ($post['type'] == 'image') : ?>
                <img src="<?php echo getImgDir() . htmlspecialchars($post['src']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
            <?php elseif ($post['type'] == 'video') : ?>
                <video controls>
                    <source src="<?php echo getVideoDir() . htmlspecialchars($post['src']); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            <?php endif; ?>
            <div class="content-text">
                <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                <div class="meta">von <?php echo htmlspecialchars($post['username']); ?> am <?php echo date('d.m.Y, H:i', strtotime($post['posted_at'])); ?></div>
                <p><?php echo nl2br(htmlspecialchars($post['description'])); ?></p>
            </div>
            <div class="post-actions">
                <form action="like.php" method="post">
                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                </form>
                <div style="display: flex; align-items: center;">
                    <span id="like-count"><?php echo $like_count; ?></span>
                    <span id="like-heart" class="like-heart"><?php include './img/like_' . ($user_has_liked ? 'filled' : 'unfilled') . '.svg'; ?></span>
                </div>
            </div>
        </div>
        <div class="comments">
            <h3>Kommentare</h3>
            <?php if (count($comments) > 0) : ?>
                <?php foreach ($comments as $comment) : ?>
                    <div class="comment">
                        <div class="comment-header">
                            <img src="<?php echo './uploads/profilePic/' . htmlspecialchars((($comment['profile_pic'] != null) && ($comment['profile_pic'] != "")) ? $comment['profile_pic'] : getDefaultProfilePic()); ?>" alt="Profilbild" class="comment-profile-pic">
                            <span class="comment-username"><?php echo htmlspecialchars($comment['username']); ?></span>
                            <span class="comment-date"><?php echo htmlspecialchars(date('d.m.Y, H:i', strtotime($comment['written_at']))); ?></span>
                        </div>
                        <div class="comment-content">
                            <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Keine Kommentare vorhanden.</p>
            <?php endif; ?>
        </div>
        <div class="add-comment">
            <h3>Kommentar schreiben</h3>
            <form action="addComm.php" method="post">
                <textarea name="comment_content" rows="4" required></textarea>
                <br>
                <input type="hidden" value="<?php echo $_GET['id']; ?>" name="post_id" id="post_id" />
                <button type="submit">Kommentar absenden</button>
            </form>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 PhotoFox. Alle Rechte vorbehalten.</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const likeHeart = document.getElementById('like-heart');
            const postId = <?php echo $post_id; ?>;

            likeHeart.addEventListener('click', function() {
                fetch('like.php', {
                        method: 'POST',
                        body: new URLSearchParams({
                            post_id: postId
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        // Nachdem der Like-Status erfolgreich aktualisiert wurde, lade die Seite neu
                        window.location.reload();
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
</body>

</html>