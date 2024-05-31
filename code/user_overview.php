<?php
$title = 'Photofox - Benutzer';
$currentPage = 'user_overview';
require_once('nav.php');
require('./database.php');
$query = "SELECT u.*, 
(SELECT COUNT(*) FROM posts WHERE user_id = u.id AND allowed = 1) AS post_quantity, 
(SELECT COUNT(*) FROM followers WHERE followed_id = u.id) AS follower_count, 
(SELECT MAX(posted_at) FROM posts WHERE user_id = u.id AND allowed = 1) AS last_post_date 
FROM users u 
WHERE u.permission_level > 3 
ORDER BY follower_count DESC, post_quantity DESC;";
$result = $conn->query($query);
?>
<link rel="stylesheet" href="./style/user_overview.css">

<body>
    <div id="user-list">
        <?php
        if ($result->num_rows > 0) {
            while ($userData = $result->fetch_assoc()) {
                if ($userData['last_post_date'] == null) {
                    $lastPostDate = 'Keine Posts gefunden';
                } else {
                    $lastPostDate = date('d.m.Y, H:i', strtotime($userData['last_post_date']));
                }
                $profilePic = !empty($userData['profile_pic']) ? './uploads/profilePic/' . $userData['profile_pic'] : './img/noProfilePic.png';
                ?>
                <a href="./display_user.php?user=<?php echo $userData['username']; ?>" class="user">
                    <img class="profile-pic" src="<?php echo $profilePic; ?>" alt="Profilbild" />
                    <div class="user-info">
                        <h3><?php echo $userData['username']; ?></h3>
                        <p>Followers: <?php echo $userData['follower_count']; ?></p>
                        <p>Anzahl der Beiträge: <?php echo $userData['post_quantity']; ?></p>
                        <?php if ($lastPost) : ?>
                            <p>Zuletzt gepostet: <?php echo $lastPostDate; ?></p>
                        <?php endif; ?>
                    </div>
                </a>
        <?php
            }
        } else {
            echo "Keine Nutzer gefunden";
        }
        ?>
    </div>
    </div>
</body>