<?php 
require_once 'header.php'; 
?>
<?php if(!empty($_SESSION['cart'])){
  $total = 0;

foreach($_SESSION['cart'] as $id => $qte){
  $dbh = connectDB();  
  $connexion = $dbh->prepare('SELECT * from products WHERE id = :id');
  // Execution de la requête 
  $connexion->execute([":id"=> $id]);
  // Récupération du résultat
  $produit = $connexion->fetch();
  echo "<img class='imgpanier' src=".$produit['img'].">".$produit['name']. " : " .$qte. ' x ' .$produit['price']. "€ = " .($produit['price']*$qte). '€';
  echo "<a class='btn btn-primary ml-3' href='deletepanier.php?id=".$produit['id']."'>Retirer au panier</a>'<br>'";
  
  $total = $total + $produit['price']*$qte;
}
echo "<p class='text-center mb-5 display-4'> Le Total est de ".$total."€</p>";
}
else{ 
  echo "<p>Panier vide</p>";
}