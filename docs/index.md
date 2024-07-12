**Photofox by Benkralex**

---

### Einrichtung der Datenbank

**Deutsch:**

1. Passen Sie die Zugangsdaten in der Datei `configs/db.json` an und wählen Sie ein sicheres Passwort.
2. Aktualisieren Sie in der Datei `configs/server.json` die Admin-Zugangsdaten, die für das Aktivieren der Nutzer mit Einmalcodes benötigt werden. Auch hier sollten Sie ein sicheres Passwort wählen.
3. Legen Sie die Berechtigungen für neue Nutzer in der Datei `configs/acc.json` fest. Wir empfehlen eine Berechtigungsskala von 0-5.
4. Führen Sie die Datei `configs/updateSQL.php` aus.
5. Öffnen Sie die Konsole des Datenbank-Servers und führen Sie die Datei `configs/photofoxDB.sql` aus.

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

1. Adjust the access credentials in the `configs/db.json` file and choose a secure password.
2. Update the admin access credentials in the `configs/server.json` file, which are required for activating users with one-time codes. Again, choose a secure password here.
3. Set the permissions for new users in the `configs/acc.json` file. We recommend a permission scale of 0-5.
4. Execute the `configs/updateSQL.php` file.
5. Open the console of the database server and execute the `configs/photofoxDB.sql` file.

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

1. Ajustez les identifiants d'accès dans le fichier `configs/db.json` et choisissez un mot de passe sécurisé.
2. Mettez à jour les identifiants d'accès admin dans le fichier `configs/server.json`, nécessaires pour activer les utilisateurs avec des codes à usage unique. Encore une fois, choisissez un mot de passe sécurisé ici.
3. Définissez les permissions pour les nouveaux utilisateurs dans le fichier `configs/acc.json`. Nous recommandons une échelle de permissions de 0 à 5.
4. Exécutez le fichier `configs/updateSQL.php`.
5. Ouvrez la console du serveur de base de données et exécutez le fichier `configs/photofoxDB.sql`.

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

**Support de utilisateurs :**

- **8 :** Approuver des utilisateurs

**Admin :**

- **9 :** Distribuer des permissions de niveau 0 à 8
- **10 :** Asseigner le niveau de permission 9

---

### Configuración de la base de datos

**Español:**

1. Ajuste las credenciales de acceso en el archivo `configs/db.json` y elija una contraseña segura.
2. Actualice en el archivo `configs/server.json` las credenciales de administrador necesarias para activar usuarios con códigos de un solo uso. Elija también una contraseña segura aquí.
3. Establezca los permisos para los nuevos usuarios en el archivo `configs/acc.json`. Recomendamos una escala de permisos de 0 a 5.
4. Ejecute el archivo `configs/updateSQL.php`.
5. Abra la consola del servidor de la base de datos y ejecute el archivo `configs/photofoxDB.sql`.

### Permisos

Un usuario puede realizar acciones que corresponden a su nivel de permiso o a un nivel inferior.

**Usuario normal:**

- **0:** Sin permisos
- **1:** Visualizar y reportar publicaciones
- **2:** Dar "me gusta" a publicaciones
- **3:** Comentar publicaciones

**Creador:**

- **4:** Publicar con aprobación
- **5:** Publicar sin aprobación

**Soporte:**

- **6:** Aprobar publicaciones
- **7:** Eliminar publicaciones

**Soporte de usuarios:**

- **8:** Aprobar usuarios

**Administrador:**

- **9:** Distribuir permisos del nivel 0 al 8
- **10:** Asignar nivel de permiso 9

---

### Configurazione del database

**Italiano:**

1. Regola le credenziali di accesso nel file `configs/db.json` e scegli una password sicura.
2. Aggiorna nel file `configs/server.json` le credenziali di amministratore necessarie per attivare gli utenti con codici monouso. Scegli anche qui una password sicura.
3. Imposta i permessi per i nuovi utenti nel file `configs/acc.json`. Raccomandiamo una scala di permessi da 0 a 5.
4. Esegui il file `configs/updateSQL.php`.
5. Apri la console del server del database ed esegui il file `configs/photofoxDB.sql`.

### Permessi

Un utente può compiere azioni che corrispondono al suo livello di permesso o inferiore.

**Utente normale:**

- **0:** Nessun permesso
- **1:** Visualizzare e segnalare pubblicazioni
- **2:** Mettere "mi piace" alle pubblicazioni
- **3:** Commentare pubblicazioni

**Creatore:**

- **4:** Pubblicare con approvazione
- **5:** Pubblicare senza approvazione

**Supporto:**

- **6:** Approvare pubblicazioni
- **7:** Eliminare pubblicazioni

**Supporto utenti:**

- **8:** Approvare utenti

**Amministratore:**

- **9:** Distribuire permessi dal livello 0 all'8
- **10:** Assegnare livello di permesso 9

---

### Configuração do banco de dados

**Português:**

1. Ajuste as credenciais de acesso no arquivo `configs/db.json` e escolha uma senha segura.
2. Atualize no arquivo `configs/server.json` as credenciais de administrador necessárias para ativar usuários com códigos de uso único. Escolha também uma senha segura aqui.
3. Defina as permissões para novos usuários no arquivo `configs/acc.json`. Recomendamos uma escala de permissões de 0 a 5.
4. Execute o arquivo `configs/updateSQL.php`.
5. Abra o console do servidor de banco de dados e execute o arquivo `configs/photofoxDB.sql`.

### Permissões

Um usuário pode realizar ações que correspondem ao seu nível de permissão ou inferior.

**Usuário normal:**

- **0:** Sem permissões
- **1:** Visualizar e relatar postagens
- **2:** Curtir postagens
- **3:** Comentar em postagens

**Criador:**

- **4:** Publicar com aprovação
- **5:** Publicar sem aprovação

**Suporte:**

- **6:** Aprovar postagens
- **7:** Excluir postagens

**Suporte de usuários:**

- **8:** Aprovar usuários

**Administrador:**

- **9:** Distribuir permissões do nível 0 ao 8
- **10:** Atribuir nível de permissão 9

---
