**README.txt**

---

### Einrichtung der Datenbank

**Deutsch:**
1. Ändern Sie den Pfad in der Datei `config.php` auf den Pfad, in dem Sie dieses Projekt installiert haben.
2. Passen Sie die Zugangsdaten in der Datei `db.json` an und wählen Sie ein sicheres Passwort.
3. Aktualisieren Sie in der Datei `server.json` die Admin-Zugangsdaten, die für das Aktivieren der Nutzer mit Einmalcodes benötigt werden. Auch hier sollten Sie ein sicheres Passwort wählen.
4. Legen Sie die Berechtigungen für neue Nutzer in der Datei `acc.json` fest. Wir empfehlen eine Berechtigungsskala von 0-5.
5. Führen Sie die Datei `updateSQL.php` aus.
6. Öffnen Sie die Konsole des Datenbank-Servers und führen Sie die Datei `photofoxDB.sql` aus.

### Permissions

Ein Benutzer kann Aktionen durchführen, die seinem Berechtigungslevel oder einem niedrigeren Level entsprechen.

**Normaler Benutzer:**
- **0:** Keine Berechtigungen
- **1:** Posts ansehen und melden
- **2:** Posts liken
- **3:** Posts kommentieren

**Ersteller:**
- **4:** Posts mit Genehmigung veröffentlichen
- **5:** Posts ohne Genehmigung veröffentlichen

**Support:**
- **6:** Posts freigeben
- **7:** Posts löschen

**Nutzer Support:**
- **8:** Nutzer freigeben

**Admin:**
- **9:** Berechtigungen von Level 0-8 verteilen
- **10:** Berechtigung Level 9 vergeben

---

### Database Setup

**English:**
1. Modify the path in the `config.php` file to the path where you have installed this project.
2. Adjust the access credentials in the `db.json` file and choose a secure password.
3. Update the admin access credentials in the `server.json` file, which are required for activating users with one-time codes. Again, choose a secure password here.
4. Set the permissions for new users in the `acc.json` file. We recommend a permission scale of 0-5.
5. Execute the `updateSQL.php` file.
6. Open the console of the database server and execute the `photofoxDB.sql` file.

### Permissions

A user can perform actions corresponding to their permission level or lower.

**Normal User:**
- **0:** No permissions
- **1:** View and report posts
- **2:** Like posts
- **3:** Comment on posts

**Creator:**
- **4:** Post with approval
- **5:** Post without approval

**Support:**
- **6:** Approve posts
- **7:** Delete posts

**User Support:**
- **8:** Approve users

**Admin:**
- **9:** Distribute permissions from level 0-8
- **10:** Assign permission level 9

---

### Configuration de la base de données

**Français:**
1. Modifiez le chemin dans le fichier `config.php` vers le chemin où vous avez installé ce projet.
2. Ajustez les identifiants d'accès dans le fichier `db.json` et choisissez un mot de passe sécurisé.
3. Mettez à jour les identifiants d'accès admin dans le fichier `server.json`, nécessaires pour activer les utilisateurs avec des codes à usage unique. Encore une fois, choisissez un mot de passe sécurisé ici.
4. Définissez les permissions pour les nouveaux utilisateurs dans le fichier `acc.json`. Nous recommandons une échelle de permissions de 0 à 5.
5. Exécutez le fichier `updateSQL.php`.
6. Ouvrez la console du serveur de base de données et exécutez le fichier `photofoxDB.sql`.

### Permissions

Un utilisateur peut effectuer des actions correspondant à son niveau de permission ou inférieur.

**Utilisateur normal :**
- **0 :** Aucune permission
- **1 :** Voir et signaler des publications
- **2 :** Mettre mi piace ai post
- **3 :** Commenter les publications

**Créateur :**
- **4 :** Publier avec approbation
- **5 :** Publier sans approbation

**Support :**
- **6 :** Approuver des publications
- **7 :** Supprimer des publications

**Support utilisateur :**
- **8 :** Approuver des utilisateurs

**Admin :**
- **9 :** Distribuer des permissions de niveau 0 à 8
- **10 :** Assigner le niveau de permission 9

---
