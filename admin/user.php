<?php
$title = 'Admin - Benutzer';
$currentPage = 'user';
require_once('nav.php');
require('../database.php');

function generateCode()
{
    // Erlaubte Zeichen
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789äöüÄÖÜß_';
    $charactersLength = mb_strlen($characters, 'UTF-8');
    $codePart1 = '';
    $codePart2 = '';

    // Generiere die ersten drei Zeichen
    for ($i = 0; $i < 3; $i++) {
        $index = random_int(0, $charactersLength - 1);
        $codePart1 .= mb_substr($characters, $index, 1, 'UTF-8');
    }

    // Generiere die zweiten drei Zeichen
    for ($i = 0; $i < 3; $i++) {
        $index = random_int(0, $charactersLength - 1);
        $codePart2 .= mb_substr($characters, $index, 1, 'UTF-8');
    }

    // Kombiniere beide Teile mit einem Bindestrich
    return $codePart1 . '-' . $codePart2;
}
?>

<body>
    <?php
    if (!isset($_GET['act'])) {
        $_GET['act'] = "overview";
    }
    if ($_GET['act'] == 'overview') {
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        $users = [];
        if ($result->num_rows > 0) {
            while ($user = $result->fetch_assoc()) {
                $users[] = $user;
            }
        }
        $perm = array_column($users, 'perm');
        $perm_count = array_count_values($perm);
        foreach ($perm_counts as $number => $count) {
            echo "$count Benutzer mit der Berechtigung $number<br>";
        }
    }
    if ($_GET['act'] == 'unlock') {
        $sql = "SELECT logincodes.code, logincodes.active, logincodes.created, users.username
            FROM logincodes
            INNER JOIN users ON logincodes.user_id = users.id
            WHERE logincodes.used = FALSE;";
        $result = $conn->query($sql);
        echo '<table id="dataTable">';
        echo '<tr><th>Code</th><th>Erstellt am</th><th>Erstellt von</th><th>Aktiv</th></tr>';
        $rowCount = 0;
        if ($result->num_rows > 0) {
            while ($code = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td class="code">' . $code['code'] . '</td>';
                echo '<td>' . $code['created'] . '</td>';
                echo '<td>' . $code['username'] . '</td>';
                echo '<td class="active">' . ($code['active'] ? 'TRUE' : 'FALSE') . '</td>';
                echo '</tr>';
                $rowCount++;
            }
            echo '</table><script src="./logincodes.js"></script>';
        } else {
            echo '</table>';
        }
        if ($rowCount < 10) {
            echo '<form method="POST" action="./user.php?act=unlock">
        <button class="btn btn-outline my-2 my-sm-0" type="submit" name="new_code" id="new_code">Neuer Code</button>
    </form>';
        }
    }
    if (isset($_POST['new_code'])) {
        $sql = "INSERT INTO logincodes (code, user_id) VALUES (
            '" . generateCode() . "',
            '" . $_SESSION['user_id'] . "'
        );";
        $result = $conn->query($sql);
        /* $_GET['act'] = "unlock"; */
        unset($_POST['new_code']);
    }
    ?>
</body>