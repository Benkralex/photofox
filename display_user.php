<?php
$title = 'Photofox - User - ' . $_GET['user'];
$currentPage = '';
require_once('nav.php');
?>
  <body>
<div id="header">
      <img
        id="profile-pic"
        src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"
        alt="Profilbild"
      />
      <h1>@Benkralex</h1>
      <p>Dies ist eine kurze Biografie, die den Benutzer beschreibt.</p>
      <p>Beiträge: 8 | Follower: 120398</p>
    </div>
    <div id="tabs">
      <button href="#" id="showAll" class="tab">Alles</button>
      <button href="#" id="showImages" class="tab">Bilder</button>
      <button href="#" id="showVideos" class="tab">Videos</button>
      <script src="user-posts-filter.js"></script>
    </div>
    <div id="main-content">
      <div class="content-box img">
        <img class="post-img" src="img/img1.jpg" alt="Beitrag" />
        <div class="post-date">
            <span class="material-symbols-rounded">calendar_month</span>
          <span class="date"> <?php echo rand(1, 30); ?>.<?php echo rand(1, 12); ?>.<?php echo rand(2008, 2024); ?> </span>
        </div>
        <div class="view-post-btn">
          <span class="material-symbols-rounded"> visibility </span>
          <span class="views"><?php echo rand(10, 150000); ?></span>
        </div>
      </div>
      <div class="content-box img">
        <img class="post-img" src="img/img2.jpg" alt="Beitrag" />
        <div class="post-date">
            <span class="material-symbols-rounded">calendar_month</span>
          <span class="date"> <?php echo rand(1, 30); ?>.<?php echo rand(1, 12); ?>.<?php echo rand(2008, 2024); ?> </span>
        </div>
        <div class="view-post-btn">
          <span class="material-symbols-rounded"> visibility </span>
          <span class="views"><?php echo rand(10, 150000); ?></span>
        </div>
      </div>
      <div class="content-box img">
        <img class="post-img" src="img/img3.jpg" alt="Beitrag" />
        <div class="post-date">
            <span class="material-symbols-rounded">calendar_month</span>
          <span class="date"> <?php echo rand(1, 30); ?>.<?php echo rand(1, 12); ?>.<?php echo rand(2008, 2024); ?> </span>
        </div>
        <div class="view-post-btn">
          <span class="material-symbols-rounded"> visibility </span>
          <span class="views"><?php echo rand(10, 150000); ?></span>
        </div>
      </div>
      <div class="content-box video">
        <img class="post-img" src="img/img4.jpg" alt="Beitrag" />
        <div class="post-date">
            <span class="material-symbols-rounded">calendar_month</span>
          <span class="date"> <?php echo rand(1, 30); ?>.<?php echo rand(1, 12); ?>.<?php echo rand(2008, 2024); ?> </span>
        </div>
        <div class="view-post-btn">
          <span class="material-symbols-rounded"> visibility </span>
          <span class="views"><?php echo rand(10, 150000); ?></span>
        </div>
      </div>
      <div class="content-box video">
        <img class="post-img" src="img/img5.jpg" alt="Beitrag" />
        <div class="post-date">
            <span class="material-symbols-rounded">calendar_month</span>
          <span class="date"> <?php echo rand(1, 30); ?>.<?php echo rand(1, 12); ?>.<?php echo rand(2008, 2024); ?> </span>
        </div>
        <div class="view-post-btn">
          <span class="material-symbols-rounded"> visibility </span>
          <span class="views"><?php echo rand(10, 150000); ?></span>
        </div>
      </div>
      <div class="content-box img">
        <img class="post-img" src="img/img6.jpg" alt="Beitrag" />
        <div class="post-date">
            <span class="material-symbols-rounded">calendar_month</span>
          <span class="date"> <?php echo rand(1, 30); ?>.<?php echo rand(1, 12); ?>.<?php echo rand(2008, 2024); ?> </span>
        </div>
        <div class="view-post-btn">
          <span class="material-symbols-rounded"> visibility </span>
          <span class="views"><?php echo rand(10, 150000); ?></span>
        </div>
      </div>
      <div class="content-box img">
        <img class="post-img" src="img/img7.jpg" alt="Beitrag" />
        <div class="post-date">
            <span class="material-symbols-rounded">calendar_month</span>
          <span class="date"> <?php echo rand(1, 30); ?>.<?php echo rand(1, 12); ?>.<?php echo rand(2008, 2024); ?> </span>
        </div>
        <div class="view-post-btn">
          <span class="material-symbols-rounded"> visibility </span>
          <span class="views"><?php echo rand(10, 150000); ?></span>
        </div>
      </div>
      <div class="content-box img">
        <img class="post-img" src="img/img8.jpg" alt="Beitrag" />
        <div class="post-date">
            <span class="material-symbols-rounded">calendar_month</span>
          <span class="date"> <?php echo rand(1, 30); ?>.<?php echo rand(1, 12); ?>.<?php echo rand(2008, 2024); ?> </span>
        </div>
        <div class="view-post-btn">
          <span class="material-symbols-rounded"> visibility </span>
          <span class="views"><?php echo rand(10, 150000); ?></span>
        </div>
      </div>
    </div>
</body>