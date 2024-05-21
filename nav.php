<?php
session_start();
if(isset($_POST['logout'])) { 
  session_destroy();
}
if (session_status() != 2 && $_SESSION['permission_level'] > 0) {
  header("Location: ' . ($currentPage === 'settings' ? '.' : '') . './acc/login.html");
  exit();
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
<title><?php echo($title); ?></title>
<link relhref="">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">  <link href="styles.css" rel="stylesheet">
<link rel="stylesheet" href=".<?php if ($currentPage === 'settings') {echo '.';} ?>/styles.css">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20,300,0,-25"
    />
    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="./img/favicon/apple-touch-icon.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="./img/favicon//favicon-32x32.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="./img/favicon//favicon-16x16.png"
    />
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href=".<?php if ($currentPage === 'settings') {echo '.';} ?>/" width="50px">
        <img class="d-inline-block align-top"
          src=".<?php if ($currentPage === 'settings') {echo '.';} ?>/img/photofox-logo.png"
          width="30"
          height="30" 
          alt="Logo"
        > Photofox</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php if ($currentPage === 'index') {echo 'active';} ?>">
        <a class="nav-link" href=".<?php if ($currentPage === 'settings') {echo '.';} ?>/">Startseite</a>
    </li>
    <li class="nav-item <?php if ($currentPage === 'user_overview') {echo 'active';} ?>">
        <a class="nav-link" href=".<?php if ($currentPage === 'settings') {echo '.';} ?>/user_overview.php">Nutzer</a>
    </li>
    <?php
     if ($_SESSION['permission_level'] > 3) {echo '
        <li class="nav-item dropdown ' . ($currentPage === 'my_posts' ? 'active' : '') . '">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMyPosts" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Meine Posts</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMyPosts">
                <a class="dropdown-item" href=".' . ($currentPage === 'settings' ? '.' : '') . '/my_posts.php?act=own">Eigene Posts</a>
                <a class="dropdown-item" href=".' . ($currentPage === 'settings' ? '.' : '') . '/my_posts.php?act=marked">Markierte Posts</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item disabled" href="#" disabled="true">Statistiken (in Arbeit)</a><!-- ./user.php?act=statistics -->
            </div>
        </li>
        <li class="nav-item ' . ($currentPage === 'new_post' ? 'active' : '') . '">
            <a class="nav-link" href=".' . ($currentPage === 'settings' ? '.' : '') . '/new_post.php">Neuen Post erstellen</a>
        </li>';
    } else { 
        echo '
        <li class="nav-item ' . ($currentPage === 'my_posts' ? 'active' : '') . '">
            <a class="nav-link" href=".' . ($currentPage === 'settings' ? '.' : '') . '/my_posts.php?act=own">Markierte Posts</a>
        </li>';
      }
      if ($_SESSION['permission_level'] > 5) {echo '
        <li class="nav-item">
            <a class="nav-link" href=".' . ($currentPage === 'settings' ? '.' : '') . '/admin">Admin-Konsole</a>
        </li>';
    }
      ?>
    </ul>
    <ul class="navbar-nav mr-right">
    <li class="nav-item <?php if ($currentPage === 'settings') {echo 'active';} ?>">
      <a class="nav-link" href="<?php if ($currentPage === 'settings') {echo '#';} else {echo './acc/';} ?>">Account verwalten</a>
    </li>
  </ul>
    <form method="post">
      <button class="btn btn-outline my-2 my-sm-0" type="submit" name="logout" id="logout">Abmelden</button>
    </form>
  </div>
</nav>