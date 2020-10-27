<?php
require_once 'header.php';
$research = $_GET["search"];
$dbh = connectDB();
$connexion = $dbh->prepare("SELECT products.* from products left join categories ON categories.id = products.id WHERE products.name like :search OR products.price like :search OR categories.name like :search group by products.id");
$connexion->execute([
    ":search" => "%" . $research . "%",
]);
$search = $connexion->fetchAll();
?>
<?php if (empty($research)) { ?>
    <div>aucun résultat</div>
<?php } else { ?>
    <div> <?php echo count($search); ?> résultats de recherche pour "<?php echo ($research); ?>"</div>
<?php } ?>
<?php if (!empty($_SESSION['user'])) { ?>
    <?php if (!empty($research)) { ?>
        <?php foreach ($search as $product) {
            if (!empty($product['img'])) {
                $nb = 100;
                if (strlen($product['description']) >= $nb) 
                $product['description'] = substr($product['description'], 0, $nb)?>
                <div class='card'>
                    <div class='card-body'>
                        <img src="<?= $product['img'] ?>" class='card-img-top' alt='...'>
                        <div class='card-body'>
                            <p class='card-title'><?= $product['name'] ?></p>
                            <p class='card-text'><?= $product['description'] ?>...</p>
                            <p class='card-text'><?= $product['price'] ?> $</p>
                            <a href='addpanier.php?id=<?= $product['id'] ?>' class='btn btn-primary'>Ajouter au panier</a>
                        </div>
                    </div>
                </div>
<?php
            }
        }
    }
} else {
     if (!empty($research)) { ?>
        <?php foreach ($search as $product) {
            if (!empty($product['img'])) {
                $nb = 100;
                if (strlen($product['description']) >= $nb) 
                $product['description'] = substr($product['description'], 0, $nb)?>
                <div class='card'>
                    <div class='card-body'>
                        <img src="<?= $product['img'] ?>" class='card-img-top' alt='...'>
                        <div class='card-body'>
                            <p class='card-title'><?= $product['name'] ?></p>
                            <p class='card-text'><?= $product['description'] ?>...</p>
                            <p class='card-text'><?= $product['price'] ?> $</p>
                        </div>
                    </div>
                </div>
<?php
            }
        }
    }
} ?>