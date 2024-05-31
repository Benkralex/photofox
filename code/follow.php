<?php
session_start();
require('./database.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id']) && isset($_POST['followed_id'])) {
    $follower_id = $_SESSION['user_id'];
    $followed_id = intval($_POST['followed_id']);

    // Prüfen, ob der Benutzer bereits folgt
    $check_follow_stmt = $conn->prepare('SELECT COUNT(*) as is_following FROM followers WHERE follower_id = ? AND followed_id = ?');
    $check_follow_stmt->bind_param('ii', $follower_id, $followed_id);
    $check_follow_stmt->execute();
    $check_follow_result = $check_follow_stmt->get_result()->fetch_assoc();

    if ($check_follow_result['is_following'] > 0) {
        // Entfolgen
        $unfollow_stmt = $conn->prepare('DELETE FROM followers WHERE follower_id = ? AND followed_id = ?');
        $unfollow_stmt->bind_param('ii', $follower_id, $followed_id);
        $unfollow_stmt->execute();
    } else {
        // Folgen
        $follow_stmt = $conn->prepare('INSERT INTO followers (follower_id, followed_id) VALUES (?, ?)');
        $follow_stmt->bind_param('ii', $follower_id, $followed_id);
        $follow_stmt->execute();
    }
}
// Zurück zur Profilseite
header("Location: display_user.php?user=" . $_POST['username']);
exit();
