<?php
header('Location: ./');
exit();
$title = 'Photofox - Einstellungen';
$currentPage = 'acc_settings';
require_once('./nav.php');
require_once('./database.php');

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

?>

<head>
    <link rel="stylesheet" href="./style/acc-settings.css">
</head>

<body>
    <div class="container">
        <h1>Account Settings</h1>
        <form action="./acc/updateUser.php" method="post">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo $email; ?>" readonly>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>">

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password">

            <label for="profile_pic">Profile Pic:</label>
            <input type="text" id="profile_pic" name="profile_pic" value="<?php echo $profile_pic; ?>">

            <label for="primary_color">Primary Color:</label>
            <input type="text" id="primary_color" name="primary_color" value="<?php echo $primary_color; ?>">

            <label for="biography">Biography:</label>
            <textarea id="biography" name="biography"><?php echo $biography; ?></textarea>

            <label for="birthday">Birthday:</label>
            <input type="date" id="birthday" name="birthday" value="<?php echo $birthday; ?>">

            <input type="submit" value="Update">
        </form>
    </div>
</body>