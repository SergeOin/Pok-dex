<?php 
require_once 'header.php';
$dbh = connectDB();
$connexion = $dbh->prepare('SELECT * from users');
$connexion->execute();
$results = $connexion->fetchAll();

//iniatilize toutes les variables
$errors = [];
$username = "";
$email = "";
$mdp = "";
$mdpconfirm = "";
$hash = "";

//Démarre l'action d'insérer
if (!empty($_POST)) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $mdpconfirm = $_POST['mdpconfirm'];
    $blacklist = ["admin", "Admin", "hack", "sql", "nazi", "error", "''",];
    $hash = hash('sha512', $mdp);
    //vérifie que tous les champs sont remplis sinon il affiche une erreur
    if (empty($username)) {
        $errors[] = "Vous devez remplir le champ prenom";
    }
    if (empty($email)) {
        $errors[] = "Vous devez remplir le champ email";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide";
    }
    if (empty($mdp)) {
        $errors[] = "Vous devez remplir le champ password";
    }
    if (in_array($username, $blacklist)) {
        $errors[] = "Utiliser des mots sans caracteres vulgaires ou incoherents !";
    }
    if (empty($mdpconfirm)) {
        $errors[] = "Vous devez remplir le champ confirmez votre password";
    }
    if($mdp != $mdpconfirm){
        $errors[] = "Les mots de passe ne correspondent pas";
    }
    //vérifie si l'email existe déjà
    $dbh = connectDB();
    $connexion = $dbh->prepare('SELECT * FROM users where email= :email');
    $connexion->execute([
        ":email" => $email,
    ]);
    $resultemail = $connexion->fetchAll();
    if($resultemail){
        $errors[] = "Email déjà existant";
    }
    //vérifie si le pseudo existe déjà
    $dbh = connectDB();
    $connexion = $dbh->prepare('SELECT * FROM users where username= :username');
    $connexion->execute([
        ":username" => $username,
    ]);
    $resultuser = $connexion->fetchAll();
    if($resultuser){
        $errors[] = "Username déjà utilisé";
    }
    //Insére dans la bdd quand tous les champs sont remplis
    if (empty($errors)) {
        $dbh = connectDB();
        $connexion = $dbh->prepare('INSERT INTO users VALUES (NULL, :username, :password, :email, :admin)');
        $connexion->execute([
            ":username" => $username,
            ":password" => $hash,
            ":email" => $email,
            ":admin" => 1,
        ]);
        $results = $connexion->fetchAll();
    }
}
?>
<form class="forminscription" method="POST">
    <div class="form-group">
        <label class="usertext">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label class="emailtext">Email</label>
        <input type="email" class="form-control" name="email">
    </div>
    <div class="form-group">
        <label class="mdptext">Password</label>
        <input type="password" class="form-control" name="mdp">
    </div>
    <div class="form-group">
        <label class="mdpconfirmtext">Confirmez votre Password</label>
        <input type="password" class="form-control" name="mdpconfirm">
    </div>
    <button type="submit" class="btn btn-primary">Valider</button>
    <?php
    if (!empty($errors)) {
        echo '<div class="alert alert-danger mt-4" role="alert">';
        echo implode ("<br>", $errors);
        echo '</div>';
    } 
    ?>
</form>
<?php require_once 'footer.php'; ?>