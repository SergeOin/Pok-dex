<?php 
require_once 'header.php';
$errors = [];
$username = "";
$email = "";
$mdp = "";
$hash = "";
$password = "";

if (!empty($_POST)) {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $admin = "";
    $hash = hash('sha512', $mdp);
    // Préparation de la requête
    $dbh = connectDB();
    $connexion = $dbh->prepare('SELECT * fROM users WHERE email = :email AND password = :password');
    // Execution de la requête 
    $connexion->execute([
    ":email" => $email,
    ":password" => $hash,
    ]);
    // Récupération du résultat
    $results = $connexion->fetchAll();

    $dbh = connectDB();
    $connexion = $dbh->prepare('SELECT password = :password from users');
    $connexion->execute([
      ":password" => $password,
    ]);
    $resultpass = $connexion->fetchAll();
    if($resultpass != $hash){
      $errors[] = 'Mot de passe incorect';
    }

    if(!empty($results)){
      $_SESSION['user'] = $results[0];
    } else {
      $_SESSION['user'] = null; 
    }
}
?>
<?php if(empty($_SESSION['user'])) {?>
<form class="formconnexion" method="POST">
<div class="form-group">
        <label class="email">Email</label>
        <input type="email" class="form-control" name="email">
    </div>
    <div class="form-group">
        <label class="mdp">Password</label>
        <input type="password" class="form-control" name="mdp">
    </div>
    <button class="btn btn-primary">Valider</button>
</form>
<?php if (!empty($errors)) {
        echo '<div class="alert alert-danger mt-4" role="alert">';
        echo implode ("<br>", $errors);
        echo '</div>';
    } ?>
<?php } else { ?>
  <?php  header('location:index.php'); ?>
<?php }?>
