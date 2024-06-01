<?php
session_start();
if (session_status() != 2 && $_SESSION['permission_level'] > 5) {
  header("Location: ./acc/login.html");
  exit();
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
  <title><?php echo ($title); ?></title>
  <link relhref="">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link href="styles.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon//favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon//favicon-16x16.png" />
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="./"><img class="d-inline-block align-top" src="../img/photofox-logo.png" width="30" height="30" alt="Logo"> ADMIN-KONSOLE</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php if ($currentPage === 'index') {
                            echo 'active';
                          } ?>">
        <a class="nav-link" href="./">Startseite</a>
      </li>
      <?php
      if ($_SESSION['permission_level'] > 7) {
        echo '
      <li class="nav-item dropdown ' . ($currentPage === 'user' ? 'active' : '') . '">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Benutzer</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownUser">
          <a class="dropdown-item" href="./user.php?act=overview">Übersicht</a>
          <a class="dropdown-item" href="./user.php?act=unlock">Nutzerfreigabe</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="./user.php?act=security">Sicherheit</a>
        </div>
      </li>';
      }
      if ($_SESSION['permission_level'] > 5) {
        echo '
      <li class="nav-item dropdown ' . ($currentPage === 'posts' ? 'active' : '') . '">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPosts" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Posts</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownPosts">
          <a class="dropdown-item" href="./posts.php?act=overview">Übersicht</a>
          <a class="dropdown-item" href="./posts.php?act=unlock">Postfreigabe</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="./posts.php?act=security">Sicherheit</a>
        </div>
      </li>';
      }
      ?>
      <li class="nav-item">
        <a class="nav-link" href="../">Photofox Startseite</a>
      </li>
    </ul>
    <!-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form> -->
  </div>
</nav>