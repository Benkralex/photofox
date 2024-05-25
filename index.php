<?php
$title = 'Photofox - Startseite';
$currentPage = 'index';
require_once('nav.php');
require_once('./database.php');
// Benutzerinformationen aus der Session
$user_id = $_SESSION['user_id'];
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

// Abrufen der neuesten Posts aus der Datenbank
$stmt = $conn->prepare('SELECT posts.*, users.username, users.profile_pic FROM posts JOIN users ON posts.user_id = users.id ORDER BY posted_at DESC LIMIT 10');
$stmt->execute();
$posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$bgColor = htmlspecialchars($_SESSION['primary_color']);
$r = hexdec(substr($bgColor, 1, 2));
$g = hexdec(substr($bgColor, 3, 2));
$b = hexdec(substr($bgColor, 5, 2));
$bgBrightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
if ($bgBrightness > 125) {
    $textColor = '#000';
} else {
    $textColor = '#fff';
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhotoFox - Startseite</title>
    <link rel="stylesheet" href="./index.css">
    <style>
        .header {
            background-color: <?php echo $bgColor; ?>;
            color: <?php echo $textColor; ?>;
        }
    </style>
</head>

<body>
    <div class="header">
        <div>
            <h1>Willkommen bei PhotoFox, <?php echo htmlspecialchars($name); ?>!</h1>
        </div>
        <div>
            <img src="<?php echo './uploads/profilePic/' . htmlspecialchars($profile_pic); ?>" alt="Profilbild">
        </div>
    </div>
    <div class="content">
        <?php foreach ($posts as $post) : ?>
            <a class="post-link" href="post.php?id=<?php echo $post['id']; ?>">
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
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="footer">
        <p>&copy; 2024 PhotoFox. Alle Rechte vorbehalten.</p>
    </div>
</body>

</html>