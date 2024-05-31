<?php
$title = 'Photofox - User - ' . $_GET['user'];
$currentPage = '';
require_once('nav.php');
require('./database.php');

if ($_SERVER["REQUEST_METHOD"] != "GET" || !isset($_GET['user'])) {
    header("Location: ./user_overview.php");
    exit();
}

$user = $_GET['user'];
$query = "SELECT u.*, 
(SELECT COUNT(*) FROM followers WHERE followed_id = u.id) AS follower_count, 
(SELECT COUNT(*) FROM posts WHERE user_id = u.id) AS posts_quantity
FROM users u WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
    $profilePic = !empty($userData['profile_pic']) ? './uploads/profilePic/' . $userData['profile_pic'] : './img/noProfilePic.png';
    $bgColor = htmlspecialchars($userData['primary_color']);
    $r = hexdec(substr($bgColor, 1, 2));
    $g = hexdec(substr($bgColor, 3, 2));
    $b = hexdec(substr($bgColor, 5, 2));
    $bgBrightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
    $textColor = $bgBrightness > 125 ? '#000' : '#fff';

    // Prüfen, ob der eingeloggte Benutzer dem aktuellen Benutzer folgt
    $is_following = false;
    if (isset($_SESSION['user_id'])) {
        $check_follow_stmt = $conn->prepare('SELECT COUNT(*) as is_following FROM followers WHERE follower_id = ? AND followed_id = ?');
        $check_follow_stmt->bind_param('ii', $_SESSION['user_id'], $userData['id']);
        $check_follow_stmt->execute();
        $check_follow_result = $check_follow_stmt->get_result()->fetch_assoc();
        $is_following = $check_follow_result['is_following'] > 0;
    }
?>
    <link rel="stylesheet" href="./style/display_user.css">
    <style>
        #header {
            background-color: <?php echo $bgColor; ?>;
            color: <?php echo $textColor; ?>;
        }
    </style>
    <div id="header">
        <img id="profile-pic" src="<?php echo $profilePic; ?>" alt="Profilbild" />
        <h1>@<?php echo htmlspecialchars($userData['username']); ?></h1>
        <p><?php echo htmlspecialchars($userData['biography']); ?></p>
        <p>Beiträge: <?php echo htmlspecialchars($userData['posts_quantity']); ?> | Follower: <?php echo $userData['follower_count']; ?></p>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $userData['id']) : ?>
            <form action="follow.php" method="post">
                <input type="hidden" name="followed_id" value="<?php echo $userData['id']; ?>">
                <input type="hidden" name="username" value="<?php echo $userData['username']; ?>">
                <button type="submit"><?php echo $is_following ? 'Entfolgen' : 'Folgen'; ?></button>
            </form>
        <?php endif; ?>
    </div>
    <div id="tabs">
        <button href="#" id="showAll" class="tab">Alles</button>
        <button href="#" id="showImages" class="tab">Bilder</button>
        <button href="#" id="showVideos" class="tab">Videos</button>
        <script src="./js/user-posts-filter.js"></script>
    </div>
    <div id="main-content">
        <?php
        // SQL-Abfrage für Beiträge des Benutzers
        $userId = $userData['id'];
        $postQuery = "SELECT p.*, 
        (SELECT COUNT(*) as view_count FROM views WHERE post_id = p.id) AS views,
        (SELECT COUNT(*) as like_count FROM likes WHERE post_id = p.id) AS likes
        FROM posts p 
        WHERE user_id = ? AND allowed = 1 
        ORDER BY posted_at DESC";
        $post_stmt = $conn->prepare($postQuery);
        $post_stmt->bind_param('i', $userId);
        $post_stmt->execute();
        $postResult = $post_stmt->get_result();

        // Überprüfen, ob Beiträge gefunden wurden
        if ($postResult->num_rows > 0) {
            while ($post = $postResult->fetch_assoc()) {
        ?>
                <div class="content-box <?php echo htmlspecialchars($post['type']); ?>">
                    <a class="post-link" href="post.php?id=<?php echo $post['id']; ?>">
                        <img class="post-img" src="./uploads/<?php echo htmlspecialchars($post['src']); ?>" alt="Beitrag" />
                        <div class="post-date">
                            <span class="material-symbols-rounded">calendar_month</span>
                            <span class="date"><?php echo date('d.m.Y', strtotime($post['posted_at'])); ?></span>
                        </div>
                        <div class="view-post-btn">
                            <span class="material-symbols-rounded">visibility</span>
                            <span class="views"><?php echo $post['views']; ?></span>
                        </div>
                        <div class="like-post-btn">
                            <span class="material-symbols-rounded">thumb_up</span>
                            <span class="likes"><?php echo $post['likes']; ?></span>
                        </div>
                    </a>
                </div>
        <?php
            }
        } else {
            echo "Keine Beiträge gefunden.";
        }
        ?>
    </div>
    </body>

<?php
} else {
    echo "Benutzer nicht gefunden.";
    /* header("Location: ./user_overview.php");
    exit(); */
}
?>