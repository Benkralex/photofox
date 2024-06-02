<?php
$title = 'Photofox - Neuer Post';
$currentPage = 'new_post';
require_once('nav.php');
require('./database.php');

$user_id = $_SESSION['user_id'];
$sql = "SELECT MAX(posted_at) AS last_post_time FROM posts WHERE user_id = ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error while preparing the statement: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Überprüfen, ob der Benutzer in der letzten Stunde bereits einen Beitrag erstellt hat
if ($row['last_post_time']) {
    $last_post_time = strtotime($row['last_post_time']);
    $current_time = time();
    $time_diff = $current_time - $last_post_time;
    if ($time_diff < getPostCooldown($_SESSION['permission_level'])) { // 3600 Sekunden = 1 Stunde
        $remaining_time = getPostCooldown($_SESSION['permission_level']) - $time_diff;
        $time_message = gmdate("hi", $remaining_time);
        die("Du kannst erst in " . $time_message . "min wieder posten");
    } elseif ($_SESSION['permission_level'] < 4) {
        die("Du hast keine Berechtigung, Posts hochzuladen");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Daten aus dem Formular erhalten
    $title = $_POST["title"];
    $description = $_POST["description"];
    $tags = explode(',', $_POST["tags"]);

    // Dateien hochladen (falls vorhanden)
    $image = $_FILES["image"]["name"];
    $video = $_FILES["video"]["name"];

    // SQL-Injection vermeiden
    $title = mysqli_real_escape_string($conn, $title);
    $description = mysqli_real_escape_string($conn, $description);
    $escaped_tags = array();
    foreach ($tags as $tag) {
        $escaped_tags[] = mysqli_real_escape_string($conn, trim($tag));
    }

    // SQL-Abfrage zum Einfügen des Beitrags in die Datenbank
    $sql = "INSERT INTO posts (user_id, title, description, src, type, tags, allowed) VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error while preparing the statement: " . $conn->error);
    }

    // Set parameters
    $type = "";
    $allowed = ($_SESSION['permission_level'] > 4);
    $tags = json_encode($escaped_tags);
    if (!empty($image)) {
        $type = "image";
        $src = $image;
    } elseif (!empty($video)) {
        $type = "video";
        $src = $video;
    }

    $stmt->bind_param("isssssi", $user_id, $title, $description, $src, $type, $tags, $allowed);

    $targetDir = './uploads/';
    $tagetFile = $targetDir . basename($_FILES[$type]['name']);
    if (move_uploaded_file($_FILES[$type]['tmp_name'], $tagetFile)) {
        echo 'Datei erfolgreich hochgeladen!<br>';
    } else {
        echo 'Fehler bei upload!';
    }

    if ($stmt->execute()) {
        echo "Post erfolgreich erstellt!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Schließen der Anweisung und Verbindung
    $stmt->close();
    $conn->close();
} else {
    echo '
<body>
    <h2>Create a New Post</h2>
    <form action="new_post.php" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" required></textarea><br><br>
        <label for="image">Select image (optional):</label><br>
        <input type="file" id="image" name="image"><br><br>
        <label for="video">Select video (optional):</label><br>
        <input type="file" id="video" name="video"><br><br>
        <label for="tags">Tags (comma separated):</label><br>
        <input type="text" id="tags" name="tags"><br><br>
        <input type="submit" value="Create Post">
    </form>
</body>
';
}
