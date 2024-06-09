<?php
$title = 'Admin - Posts';
$currentPage = 'posts';
require_once('nav.php');
echo '<link rel="stylesheet" href="./posts.css">';
require('../database.php');
?>

<body>
    <?php
    if (!isset($_GET['act'])) {
        $_GET['act'] = "overview";
    }
    if ($_GET['act'] == 'overview') {
        echo '<h1>Übersicht</h1>';
    }
    if ($_GET['act'] == 'unlock') {
        echo '<h1>Freigabe</h1>';
        $sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE allowed = FALSE;";
        $result = $conn->query($sql);
        echo '<table id="dataTable">';
        echo '<tr><th>Titel</th><th>Beschreibung</th><th>Nutzer</th><th>Tags</th><th>Bild/Video</th></tr>';
        if ($result->num_rows > 0) {
            while ($post = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $post['title'] . '</td>';
                echo '<td>' . $post['description'] . '</td>';
                echo '<td>' . $post['username'] . '</td>';
                echo '<td>' . $post['tags'] . '</td>';
                echo '<td>' . getPostSrc($post['type'], $post['src']) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '</table>';
        }
    }
    if ($_GET['act'] == 'security') {
        echo '<h1>Sicherheit</h1>';
    }
    ?>
</body>