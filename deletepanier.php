<?php
session_start();
$produit_id = $_GET['id'];
if(empty($_SESSION['cart'][$produit_id])){
$_SESSION['cart'][$produit_id] = 1;
}
else{
    $_SESSION['cart'][$produit_id] = $_SESSION['cart'][$produit_id] - 1;
}
header('location:panier.php?id='.$produit_id);
?>