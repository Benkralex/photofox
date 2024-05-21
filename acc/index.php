<?php
$title = 'Photofox - Einstellungen';
$currentPage = 'settings';
require_once('../nav.php');
?>
<body>
    <?php echo 'E-Mail: '.$_SESSION['email'].'<br>Name: '.$_SESSION['name'].'<br>Nutzername: '.$_SESSION['username'].'<br>Profielbild: '.$_SESSION['profil_pic']
    .'<br>Farbe: '.$_SESSION['primary_color'].'<br>Biografie: '.$_SESSION['biography'].'<br>Geburtstag: '.$_SESSION['birthday'].'<br>Verwarnungen: '.$_SESSION['warnings']
    .'<br>Mitglied seit: '.$_SESSION['member_since'];
    ?><br><br>
    <form methode="GET" action="./updateUser.php">
        <select id="field" name="field">
            <option value="email">Email</option>
            <option value="name">Name</option>
            <option value="username">Nutzername</option>
            <option value="primary_color">Profiel Farbe</option>
            <option value="biography">Biografie</option>
            <option value="birthday">Geburtstag</option>
        </select><br>
        <input type="text" id="value" placeholder="Neuer Wert" name="value"/>
        <button type="submit">Ändern</button>
    </form>
</body>
