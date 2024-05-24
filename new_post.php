<?php
$title = 'Photofox - Neuer Post';
$currentPage = 'new_post';
require_once('nav.php');
require('./database.php');

$user_id = $_SESSION['user_id'];
    $sql = "SELECT MAX(posted_at) AS last_post_time FROM posts WHERE user_id = ?";
    
    $stmt = $conn->prepare($sql);
    if($stmt === false) {
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

        if ($time_diff < 3600) { // 3600 Sekunden = 1 Stunde
            $remaining_time = 3600 - $time_diff;
            $time_message = gmdate("i", $remaining_time);
            die("Du kannst erst in ".$time_message."min wieder posten");
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
    $sql = "INSERT INTO posts (user_id, title, description, src, type, tags) VALUES (?, ?, ?, ?, ?, ?)";
    
    // Prepare statement
    $stmt = $conn->prepare($sql);
    if($stmt === false) {
        die("Error while preparing the statement: " . $conn->error);
    }

    // Set parameters
    $type = "";
    $tags = json_encode($escaped_tags);
    if (!empty($image)) {
        $type = "image";
        $src = $image;
    } elseif (!empty($video)) {
        $type = "video";
        $src = $video;
    }

    $stmt->bind_param("isssss", $user_id, $title, $description, $src, $type, $tags);

    if ($stmt->execute()) {
        $sql_update = "UPDATE users SET posts_quantity = posts_quantity + 1 WHERE id = ?";
        
        $stmt_update = $conn->prepare($sql_update);
        if($stmt_update === false) {
            die("Error while preparing the statement: " . $conn->error);
        }

        $stmt_update->bind_param("i", $user_id);

        if ($stmt_update->execute()) {
            echo "Post created successfully!";
        } else {
            echo "Error updating user's post quantity: " . $conn->error;
        }

        $stmt_update->close();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Schließen der Anweisung und Verbindung
    $stmt->close();
    $conn->close();
}
?>
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
