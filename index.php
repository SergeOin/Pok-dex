<?php
require_once 'header.php';
$dbh = connectDB();
$connexion = $dbh->prepare('SELECT * from products');
$connexion->execute();
$results = $connexion->fetchAll();

$dbh = connectDB();
$connexion = $dbh->prepare('SELECT products.category_id, categories.name, categories.parent_id from products left join categories ON products.category_id = categories.parent_id');
$connexion->execute();
$resultstype = $connexion->fetchAll();

$id = "";
$dbh = connectDB();
$connexion = $dbh->prepare('SELECT * from categories');
$connexion->execute([
    ":id" => $id,
]);
$resultsid = $connexion->fetchAll();
?>
<section>
    <div class="btn-group-mr-2" role="group" aria-label="Basic example" id="filter">
        <button value="alltype" type="button" class="btn btn-secondary">Tous les types</button>
        <button value="firetype" type="button" class="btn btn-secondary">Type feu</button>
        <button value="watertype" type="button" class="btn btn-secondary">Type eau</button>
        <button value="flytype" type="button" class="btn btn-secondary">Type vol</button>
        <button value="electype" type="button" class="btn btn-secondary">Type electrik</button>
    </div>
        <div class="card-deck">
            <?php foreach ($results as $result => $resultproduct) {
                $resulttype = $resultstype[$result];
                $nb = 100;
                if (strlen($resultproduct['description']) >= $nb)
                    $resultproduct['description'] = substr($resultproduct['description'], 0, $nb) ?>
                <div class='card'>
                    <div class='card-body'>
                        <img src="<?= $resultproduct['img'] ?>" class='card-img-top' alt='...'>
                        <div class='card-body'>
                            <p class='card-title'><?= $resultproduct['name'] ?></p>
                            <p class='card-text'><?= $resultproduct['description'] ?>...</p>
                            <p class='card-text'><?= $resulttype['name'] ?></p>
                            <p class='card-text'><?= $resultproduct['price'] ?> $</p>
                            <a href='addpanier.php?id=<?= $resultproduct['id'] ?>' class='btn btn-primary'>Ajouter au panier</a>
                            <a href='product.php?id=<?= $resultproduct['id'] ?>' class='btn btn-primary'>Détail du Pokémon</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
</section>
<?php require_once 'footer.php'; ?>