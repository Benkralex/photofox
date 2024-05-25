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
$query = "SELECT * FROM users WHERE username = '$user'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
    $profilePic = !empty($userData['profile_pic']) ? './uploads/profilePic/' . $userData['profile_pic'] : './img/noProfilePic.png';
    $bgColor = htmlspecialchars($userData['primary_color']);
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
    <link rel="stylesheet" href="./display_user.css">
    <style>
        #header {
            background-color: <?php echo $bgColor; ?>;
            color: <?php echo $textColor; ?>;
        }
    </style>
    <div id="header">
        <img id="profile-pic" src="<?php echo $profilePic; ?>" alt="Profilbild" />
        <h1>@<?php echo $userData['username']; ?></h1>
        <p><?php echo $userData['biography']; ?></p>
        <p>Beiträge: <?php echo $userData['posts_quantity']; ?> | Follower: <?php echo $userData['followers']; ?></p>
    </div>
    <div id="tabs">
        <button href="#" id="showAll" class="tab">Alles</button>
        <button href="#" id="showImages" class="tab">Bilder</button>
        <button href="#" id="showVideos" class="tab">Videos</button>
        <script src="user-posts-filter.js"></script>
    </div>
    <div id="main-content">
        <?php
        // SQL-Abfrage für Beiträge des Benutzers
        $userId = $userData['id'];
        $postQuery = "SELECT * FROM posts WHERE user_id = '$userId' AND allowed = 1 ORDER BY posted_at DESC";
        $postResult = $conn->query($postQuery);

        // Überprüfen, ob Beiträge gefunden wurden
        if ($postResult->num_rows > 0) {
            while ($post = $postResult->fetch_assoc()) {
        ?>
                <div class="content-box <?php echo $post['type']; ?>">
                    <a class="post-link" href="post.php?id=<?php echo $post['id']; ?>">
                        <img class="post-img" src="./uploads/<?php echo $post['src']; ?>" alt="Beitrag" />
                        <div class="post-date">
                            <span class="material-symbols-rounded">calendar_month</span>
                            <span class="date"><?php echo date('d.m.Y', strtotime($post['posted_at'])); ?></span>
                        </div>
                        <div class="view-post-btn">
                            <span class="material-symbols-rounded">visibility</span>
                            <span class="views"><?php echo $post['views']; ?></span>
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