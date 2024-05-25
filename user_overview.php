<?php
$title = 'Photofox - Benutzer';
$currentPage = 'user_overview';
require_once('nav.php');
require('./database.php');
$query = "SELECT * FROM users WHERE permission_level > 3 ORDER BY followers DESC, posts_quantity DESC";
$result = $conn->query($query);
?>
<link rel="stylesheet" href="./user_overview.css">
<body>
    <div id="user-list">
        <?php
        if ($result->num_rows > 0) {
            while ($userData = $result->fetch_assoc()) {
                // Profilbild überprüfen
                $profilePic = !empty($userData['profile_pic']) ? './uploads/profilePic/'.$userData['profile_pic'] : './img/noProfilePic.png';
                // Letzter Beitrag des Benutzers abrufen
                $lastPostQuery = "SELECT * FROM posts WHERE user_id = '{$userData['id']}' ORDER BY posted_at DESC LIMIT 1";
                $lastPostResult = $conn->query($lastPostQuery);
                $lastPost = $lastPostResult->fetch_assoc();
                ?>
                <a href="./display_user.php?user=<?php echo $userData['username']; ?>" class="user">
                    <img class="profile-pic" src="<?php echo $profilePic; ?>" alt="Profilbild" />
                    <div class="user-info">
                        <h3><?php echo $userData['username']; ?></h3>
                        <p>Followers: <?php echo $userData['followers']; ?></p>
                        <p>Anzahl der Beiträge: <?php echo $userData['posts_quantity']; ?></p>
                        <?php if ($lastPost) : ?>
                            <p>Zuletzt gepostet: <?php echo date('d.m.Y, H:i', strtotime($lastPost['posted_at'])); ?></p>
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