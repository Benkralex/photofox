<?php
function getConfig($configFile)
{
    if (!file_exists($configFile)) {
        die("Konfigurationsdatei nicht gefunden!");
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
    $file = __DIR__ . '/acc.json';
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
    $file = __DIR__ . '/db.json';
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
    $file = __DIR__ . '/upload.json';
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
    $file = __DIR__ . '/upload.json';
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
function getProfilePDir()
{
    $file = __DIR__ . '/upload.json';
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
    $file = __DIR__ . '/security-config.json';
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
    $file = __DIR__ . '/security-config.json';
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