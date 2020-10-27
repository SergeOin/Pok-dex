<?php
require_once 'header.php';
$id = $_GET['id'];
$dbh = connectDB();
$connexion = $dbh->prepare('SELECT * from products where id = :id');
$connexion->execute([
    ":id" => $id,
]);
$results = $connexion->fetchAll();

$dbh = connectDB();
$connexion = $dbh->prepare('SELECT products.category_id, categories.name, categories.parent_id from products left join categories ON products.category_id = categories.parent_id');
$connexion->execute();
$resultstype = $connexion->fetchAll();
?>
<?php foreach ($results as $result => $resultproduct) {
    $resulttype = $resultstype[$result]; ?>
    <div class='card mx-auto'>
        <div class='card-body'>
            <img src="<?= $resultproduct['img'] ?>" class='card-img-top' alt='...'>
            <div class='card-body'>
                <p class='card-title'><?= $resultproduct['name'] ?></p>
                <p class='card-text'><?= $resultproduct['description'] ?></p>
                <p class='card-text'><?= $resulttype['name'] ?></p>
                <p class='card-text'><?= $resultproduct['price'] ?> $</p>
                <a href='addpanier.php?id=<?= $resultproduct['id'] ?>' class='btn btn-primary'>Ajouter au panier</a>
            </div>
        </div>
    </div>
<?php } ?>