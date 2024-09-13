<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $title ?>
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <?php if(!isset($url[1])):?>
        <link rel="stylesheet" href="assets/css/style.css">
    <?php else:?>
      <link rel="stylesheet" href="../assets/css/style.css">
    <?php endif?>
  </head>
  <body>

    <?php if($action !== "Login" && $action !=="Signin"):?>
      <div class="header">
          <div class="title-project">
            <a href="<?php echo BASE_URL.SP."Accueil"?>">Prince Gestion Projet</a>
          </div>
          <div class="profile">
              <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="assets/images/9642_avatar.jpg" alt=""> <?php echo isset($_SESSION['user']) ? $_SESSION['user']['pseudo']." - ".ucwords($_SESSION['user']['status']) : "" ?>
              </button>
              <ul class="dropdown-menu dropdown-menu-dark my-3">
                <li><a class="dropdown-item" href="<?php echo BASE_URL.SP."Compte"?>">Mon Compte</a></li>
                <li><a class="dropdown-item" href="<?php echo BASE_URL.SP."Login"?>">Déconnexion</a></li>
              </ul>
          </div>
      </div>
      <div class="content">
        <nav class="navbar navbar-expand-lg ">
          <ul class="navbar-nav">
                    <li class="nav-item">
                        <?php if($action === "Accueil"):?>
                          <a href="<?php echo BASE_URL.SP."Accueil"?>" class="nav-link active"><i class="fa fa-fw fa-dashboard fs-3 "></i> <small>Tableau de bord</small></a>
                        <?php else :?>
                          <a href="<?php echo BASE_URL.SP."Accueil"?>" class="nav-link"><i class="fa fa-fw fa-dashboard fs-3"></i> <small>Tableau de bord</small></a>
                        <?php endif ?>
                    </li>
                    <li class="nav-item">
                        <?php if($action === "Projets" || $action==="ProjetsAction"):?>
                          <a href="<?php echo BASE_URL.SP."Projets"?>" class="nav-link active"><i class="fa-solid fa-bars fs-3"></i><small> Projets</small></a>
                        <?php else :?>
                          <a href="<?php echo BASE_URL.SP."Projets"?>" class="nav-link"><i class="fa-solid fa-bars fs-3"></i></i> <small> Projets</small></a>
                        <?php endif ?>
                    </li>
                    <li class="nav-item">
                        <?php if($action === "Taches"):?>
                          <a href="<?php echo BASE_URL.SP."Taches"?>" class="nav-link active"><i class="fa-solid fa-list-check fs-3"></i>  <small> Taches</small></a>
                        <?php else :?>
                          <a href="<?php echo BASE_URL.SP."Taches"?>" class="nav-link"><i class="fa-solid fa-list-check fs-3"></i>  <small> Taches</small></a>
                        <?php endif ?>
                    </li>
                    <li class="nav-item">
                    <?php if($_SESSION['user']['status'] === "admin"):?>
                      <?php if($action === "Membres"):?>
                        <a href="<?php echo BASE_URL.SP."Membres"?>" class="nav-link active"><i class="fa fa-users fs-3"></i> <small>Membres</small></a> 
                      <?php else :?>
                        <a href="<?php echo BASE_URL.SP."Membres"?>" class="nav-link"><i class="fa fa-users fs-3"></i> <small>Membres</small></a>
                      <?php endif ?>
                    <?php endif ?>
                    </li> 
          </ul>
        </nav>
        <div class="container-content">
            <?php
                echo $content
            ?>
        </div>
      </div>
      <footer>
        Prince Gestion Projet 2024 All rights reserved.
      </footer>
    <?php else :?>
      <div class="container-fluid">
            <?php
                echo $content
            ?>
        </div>
    <?php endif?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>