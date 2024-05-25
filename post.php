<?php
if ($_SERVER["REQUEST_METHOD"] != "GET" || !isset($_GET['id'])) {
    header("Location: ./");
    exit();
}

$title = 'Photofox - Post - ' . $_GET['id'];
$currentPage = '';
require_once('nav.php');
require_once 'database.php';

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Post-ID aus der URL abrufen
$post_id = intval($_GET['id']);

if ($post_id <= 0) {
    die("Ungültige Post-ID.");
}

// Überprüfen, ob ein Eintrag in der views-Tabelle für diesen Benutzer und diesen Post existiert
$user_id = $_SESSION['user_id'];
$view_check_stmt = $conn->prepare('SELECT * FROM views WHERE user_id = ? AND post_id = ?');
$view_check_stmt->bind_param('ii', $user_id, $post_id);
$view_check_stmt->execute();
$view_exists = $view_check_stmt->get_result()->num_rows > 0;

if (!$view_exists) {
    // Eine neue Ansicht für den Post hinzufügen
    $insert_view_stmt = $conn->prepare('INSERT INTO views (user_id, post_id) VALUES (?, ?)');
    $insert_view_stmt->bind_param('ii', $user_id, $post_id);
    $insert_view_stmt->execute();
}

// Den spezifischen Post aus der Datenbank abrufen
$stmt = $conn->prepare('SELECT posts.*, users.username, users.profile_pic FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?');
$stmt->bind_param('i', $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    die("Post nicht gefunden.");
}

// Kommentare zu diesem Post abrufen
$comment_stmt = $conn->prepare('SELECT comments.*, users.username, users.profile_pic FROM comments JOIN users ON comments.user_id = users.id WHERE comments.post_id = ? AND comments.allowed = 1 ORDER BY comments.written_at ASC');
$comment_stmt->bind_param('i', $post_id);
$comment_stmt->execute();
$comments = $comment_stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Anzahl der Likes für den Post abrufen
$like_stmt = $conn->prepare('SELECT COUNT(*) as like_count FROM likes WHERE post_id = ?');
$like_stmt->bind_param('i', $post_id);
$like_stmt->execute();
$like_count = $like_stmt->get_result()->fetch_assoc()['like_count'];

// Prüfen, ob der Benutzer den Post bereits geliked hat
$user_like_stmt = $conn->prepare('SELECT * FROM likes WHERE user_id = ? AND post_id = ?');
$user_like_stmt->bind_param('ii', $user_id, $post_id);
$user_like_stmt->execute();
$user_has_liked = $user_like_stmt->get_result()->num_rows > 0;

// Benutzerinformationen aus der Session
$email = $_SESSION['email'];
$name = $_SESSION['name'];
$username = $_SESSION['username'];
$permission_level = $_SESSION['permission_level'];
$profile_pic = $_SESSION['profile_pic'];
$member_since = $_SESSION['member_since'];
$warnings = $_SESSION['warnings'];
$primary_color = $_SESSION['primary_color'];
$biography = $_SESSION['biography'];
$birthday = $_SESSION['birthday'];
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - PhotoFox</title>
    <link rel="stylesheet" href="post.css">
    <style>
        .like-heart {
            cursor: pointer;
            width: 24px;
            height: 24px;
            background-repeat: no-repeat;
            background-size: contain;
            vertical-align: middle;
            /* Hier hinzugefügt */
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="post">
            <?php if ($post['type'] == 'image') : ?>
                <img src="<?php echo './uploads/' . htmlspecialchars($post['src']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
            <?php elseif ($post['type'] == 'video') : ?>
                <video controls>
                    <source src="<?php echo './uploads/' . htmlspecialchars($post['src']); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            <?php endif; ?>
            <div class="content-text">
                <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                <div class="meta">von <?php echo htmlspecialchars($post['username']); ?> am <?php echo htmlspecialchars($post['posted_at']); ?></div>
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
                            <img src="<?php echo './uploads/profilePic/' . htmlspecialchars($comment['profile_pic']); ?>" alt="Profilbild" class="comment-profile-pic">
                            <span class="comment-username"><?php echo htmlspecialchars($comment['username']); ?></span>
                            <span class="comment-date"><?php echo htmlspecialchars($comment['written_at']); ?></span>
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