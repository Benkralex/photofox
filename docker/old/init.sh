#!/bin/bash

# Klone das Git-Repository in einen temporären Ordner
git clone https://github.com/Benkralex/photofox /tmp/repo

# Erstelle das Zielverzeichnis, falls es nicht existiert
mkdir -p ./web

# Kopiere den Inhalt des 'code'-Ordners in das Web-Verzeichnis
cp -r /tmp/repo/code/* ./web/

# Kopiere die Konfigurationsdateien in das 'configs'-Verzeichnis im Web-Verzeichnis
cp -r ./configs/* ./web/configs/

# Warte, bis die Datenbank bereit ist
while ! docker exec db mysqladmin --user=root --password=rootpass ping --silent &> /dev/null ; do
    echo "Warte auf Datenbank..."
    sleep 2
done

# Führe die PHP-Datei aus
docker exec web php /var/www/html/configs/updateSQL.php

# Führe die SQL-Datei auf dem MySQL-Server aus, um die Datenbank zu erstellen
docker exec -i db mysql -u root -p rootpass < ./web/configs/photofoxDB.sql

# Aufräumen des temporären Repository-Ordners
rm -rf /tmp/repo
