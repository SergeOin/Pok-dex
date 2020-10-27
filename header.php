<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="fr-FR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Pokédex</title>
  <meta name="description" content="">
  <link rel="icon" type="image/svg" href="img/pokeball.svg" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg">
      <a class="navbar-brand" href="index.php"><img class="logo" src="img/pokelogo.svg" alt="Logo Pokémon"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <?php if (!empty($_SESSION['user'])) { ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <p class="textheader">Le dresseur <?php echo $_SESSION['user']['username']; ?> est connecte(e)</p>
            <!-- <li class="nav-item active">
              <a class="nav-link" href="connexion.php">Connexion</a>
            </li> 
            <li class="nav-item">
              <a class="nav-link" href="inscription.php">Inscription</a>
            </li>-->
          </ul>
          <a class="nav-link" href="panier.php"><img src="img/cart.svg" width="30" height="30"></a>
          <a class="nav-link" href="logout.php"><img src="img/pokeball.svg" width="30" height="30"></a>
          <form action="search.php" method="GET" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
          </form>
        </div>
      <?php } ?>
      <?php if(empty($_SESSION['user'])) { ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="connexion.php">Connexion</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="inscription.php">Inscription</a>
            </li>
          </ul>
          <a class="nav-link" href="panier.php"><img src="img/cart.svg" width="30" height="30"></a>
          <!-- <a class="nav-link" href="logout.php"><img src="img/pokeball.svg" width="30" height="30"></a>-->
          <form action="search.php" method="GET" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
          </form>
        </div>
      <?php } ?>
    </nav>
  </header>
  <main>