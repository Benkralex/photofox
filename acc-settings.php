<?php
$title = 'Photofox - Einstellungen';
$currentPage = 'acc_settings';
require_once('./nav.php');
?>

<body>
    <div style="display: flex;width: 100%;">
        <?php echo '<div class="content"> E-Mail: <div class="disabled-div">' . $_SESSION['email'] . '</div>'
            . '<br>Name: <div class="disabled-div">' . $_SESSION['name'] . '</div>'
            . '<br>Nutzername: <div class="disabled-div">' . $_SESSION['username'] . '</div>'
            . '<br>Profielbild: <div class="disabled-div">' . $_SESSION['profil_pic'] . '</div>'
            . '<br>Farbe: <div class="disabled-div">' . $_SESSION['primary_color'] . '</div>'
            . '<br>Biografie: <div class="disabled-div">' . $_SESSION['biography'] . '</div>'
            . '<br>Geburtstag: <div class="disabled-div">' . $_SESSION['birthday'] . '</div>'
            . '<br>Verwarnungen: <div class="disabled-div">' . $_SESSION['warnings'] . '</div>'
            . '<br>Mitglied seit: <div class="disabled-div">' . $_SESSION['member_since'] . '</div></div>';
        ?><br><br>
        <div class="content">
            <form methode="GET" action="./updateUser.php">
                <select id="field" name="field">
                    <option value="email">Email</option>
                    <option value="name">Name</option>
                    <option value="username">Nutzername</option>
                    <option value="primary_color">Profiel Farbe</option>
                    <option value="biography">Biografie</option>
                    <option value="birthday">Geburtstag</option>
                </select><br>
                <input type="text" id="value" placeholder="Neuer Wert" name="value" />
                <button type="submit">Ändern</button>
            </form>
        </div>
    </div>
</body>