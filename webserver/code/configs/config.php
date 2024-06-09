<?php
const CONFIG_PATH = "/home/container/conf";
function getConfig($configFile)
{
    if (!file_exists($configFile)) {
        die("Konfigurationsdatei \"" . $configFile . "\" nicht gefunden!");
    }

    $configData = file_get_contents($configFile);
    return json_decode($configData, true);
}
function saveConfig($configFile, $config)
{
    $configData = json_encode($config, JSON_PRETTY_PRINT);
    if (file_put_contents($configFile, $configData) === false) {
        die("Fehler beim Schreiben der Konfigurationsdatei.");
    }
}
function addConfigKey($configFile, $key, $value)
{
    $config = getConfig($configFile);
    if (!isset($config[$key])) {
        $config[$key] = $value;
        saveConfig($configFile, $config);
    }
}
function getDefaultPerm()
{
    $file = CONFIG_PATH . '/acc.json';
    $config = getConfig($file);
    if (isset($config['default-permission'])) {
        return $config['default-permission'];
    } else {
        addConfigKey($file, 'default-permission', 0);
        return 0;
    }
}
function getDBConn()
{
    $file = CONFIG_PATH . '/db.json';
    $config = getConfig($file);
    $conn = new mysqli(
        $config['db_host'],
        $config['db_user'],
        $config['db_pass'],
        $config['db_name']
    );
    return $conn;
}
function getImgDir()
{
    $file = CONFIG_PATH . '/upload.json';
    $config = getConfig($file);
    $key = 'post-image';
    if (isset($config[$key])) {
        return $config[$key];
    } else {
        $value = './uploads/';
        addConfigKey($file, $key, $value);
        return $value;
    }
}
function getVideoDir()
{
    $file = CONFIG_PATH . '/upload.json';
    $config = getConfig($file);
    $key = 'post-video';
    if (isset($config[$key])) {
        return $config[$key];
    } else {
        $value = './uploads/';
        addConfigKey($file, $key, $value);
        return $value;
    }
}
function getDefaultProfilePic()
{
    $file = CONFIG_PATH . '/upload.json';
    $config = getConfig($file);
    $key = 'noProfilePic-pic';
    if (isset($config[$key])) {
        return $config[$key];
    } else {
        $value = 'noProfilePic.png';
        addConfigKey($file, $key, $value);
        return $value;
    }
}
function getPostSrc($type, $src)
{
    if ($type == 'image') {
        echo '<img class="post-src" src="../' . getImgDir() . htmlspecialchars($src) . '">';
    } elseif ($type == 'video') {
        echo '<video controls>
            <source class="post-src" src="../' . getVideoDir() . htmlspecialchars($src) . '" type="video/mp4">Your browser does not support the video tag.</video>';
    }
}
function getProfilePDir()
{
    $file = CONFIG_PATH . '/upload.json';
    $config = getConfig($file);
    $key = 'profile-picture';
    if (isset($config[$key])) {
        return $config[$key];
    } else {
        $value = './uploads/profilePic/';
        addConfigKey($file, $key, $value);
        return $value;
    }
}
function getPassReq()
{
    $file = CONFIG_PATH . '/security-config.json';
    $config = getConfig($file);
    $key = 'pass-requirements';
    if (isset($config[$key])) {
        return $config[$key];
    } else {
        $value = [
            "CapitalLetter" => true,
            "SmallLetter" => true,
            "Number" => true,
            "SpecialCharacter" => true,
            "MinLength" => 8
        ];
        addConfigKey($file, $key, $value);
        return $value;
    }
}
function getPermTrigger()
{
    $file = CONFIG_PATH . '/security-config.json';
    $config = getConfig($file);
    $key = 'perm-trigger';
    if (isset($config[$key])) {
        return $config[$key];
    } else {
        $value = [
            "5" => [100, "Es sind &over Benutzer über dem empfohlenen Limit."],
            "6" => [50, "Es sind &over Benutzer über dem empfohlenen Limit."],
            "7" => [50, "Es sind &over Benutzer über dem empfohlenen Limit."],
            "8" => [10, "Es sind &over Benutzer über dem empfohlenen Limit."],
            "9" => [3, "Es sollten nicht zu viele Benutzer mit dem Berechtigungslevel 9 existieren. Zurzeit sind &over über dem empfohlenen Limit."],
            "10" => [1, "Es sollte nur einen Nutzer mit dem Berechtigungslevel 10 existieren"]
        ];
        addConfigKey($file, $key, $value);
        return $value;
    }
}
function getAdminUsername()
{
    $file = CONFIG_PATH . '/server.json';
    $config = getConfig($file);
    $key = 'adminUsername';
    if (isset($config[$key])) {
        return $config[$key];
    } else {
        $value = "ADMIN";
        addConfigKey($file, $key, $value);
        return $value;
    }
}
function getPostCooldown($key)
{
    $file = CONFIG_PATH . '/post-cooldown.json';
    $config = getConfig($file);
    if (isset($config[$key])) {
        return $config[$key];
    } else {
        $value = ($key < 6) ? 3600 : (($key > 8) ? 0 : 360);
        addConfigKey($file, $key, $value);
        return $value;
    }
}
