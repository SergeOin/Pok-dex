<?php
require_once 'db.php';
$errors = [];
$item_id = $_POST['itemId'];
var_dump($item_id);
$name = "";
$price = "";
$category_id = "";
$img = "";
$description = "";

if (!empty($_POST)) {
    $item_id = $_POST['itemId'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $img = $_POST['img'];
    $description = $_POST['description'];

    if (empty($name)) {
        $errors[] = "Remplissez le nom du pokémon";
    }
    if (empty($price)) {
        $errors[] = "Veuillez ajouter un prix";
    }
    if (empty($category_id)) {
        $errors[] = "Sélectionnez un type";
    }
    if (empty($img)) {
        $errors[] = "veuillez ajouter une url d'image";
    }
    if (empty($description)) {
        $errors[] = "Veuillez ajouter une description";
    }

    if (empty($errors)) {
        $dbh = connectDB();
        $connexion = $dbh->prepare('UPDATE products SET name = :name, price = :price, category_id = :category_id, img = :img, description = :description WHERE id = :id');
        $connexion->execute([
            ":name" => $name,
            ":price" => $price,
            "category_id" => $category_id,
            ":img" => $img,
            ":description" => $description,
            ":id" => $item_id,
        ]);
        $results = $connexion->fetchAll();
    }
   header("Location:backadmin.php");
    exit;
}
