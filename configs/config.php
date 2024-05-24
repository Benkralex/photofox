<?php
//Path, were the project is intalled
define('MAIN_LOC', 'C:/xampp/htdocs/photofox');



//Don't change
function getConfig($configFile) {
    if (!file_exists($configFile)) {
        die("Konfigurationsdatei nicht gefunden!");
    }

    $configData = file_get_contents($configFile);
    return json_decode($configData, true);
}
function saveConfig($configFile, $config) {
    $configData = json_encode($config, JSON_PRETTY_PRINT);
    if (file_put_contents($configFile, $configData) === false) {
        die("Fehler beim Schreiben der Konfigurationsdatei.");
    }
}
function addConfigKey($configFile, $key, $value) {
    $config = getConfig($configFile);
    if (!isset($config[$key])) {
        $config[$key] = $value;
        saveConfig($configFile, $config);
    }
}
function getDefaultPerm() {
    $file = MAIN_LOC.'/configs/acc.json';
    echo $file;
    $config = getConfig($file);
    if (isset($config['default-permission'])) {
        return $config['default-permission'];
    } else {
        addConfigKey($file, 'default-permission', 0);
        return 0;
    }
}
function getDBConn() {
    $config = getConfig(MAIN_LOC.'/configs/db.json');
    $conn = new mysqli(
        $config['db_host'], 
        $config['db_user'], 
        $config['db_pass'], 
        $config['db_name']
    );
    return $conn;
}
?>