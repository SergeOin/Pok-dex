<?php
require_once 'header.php';
$dbh = connectDB();
$connexion = $dbh->prepare('SELECT * from users');
$connexion->execute();
$resultuser = $connexion->fetchAll();

if (!empty($_SESSION['user'])) {
    $id = $_SESSION['user']['admin'];
    if ($id == 0) {
        // nothing
    } else {
        header('location:index.php');
    }
} else {
    header('location:index.php');
}

$dbh = connectDB();
$connexion = $dbh->prepare('SELECT * from products');
$connexion->execute();
$resultats = $connexion->fetchAll();

$dbh = connectDB();
$connexion = $dbh->prepare('SELECT products.category_id, categories.name, categories.parent_id from products left join categories ON products.category_id = categories.parent_id');
$connexion->execute();
$resultstype = $connexion->fetchAll();

$errorsinsert = [];
$name = "";
$price = "";
$category_id = "";
$img = "";
$description = "";

if (!empty($_POST)) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $img = $_POST['img'];
    $description = $_POST['description'];

    if (empty($name)) {
        $errorsinsert[] = "Remplissez le nom du pokémon";
    }
    if (empty($price)) {
        $errorsinsert[] = "Veuillez ajouter un prix";
    }
    if (empty($category_id)) {
        $errorsinsert[] = "Sélectionnez un type";
    }
    if (empty($img)) {
        $errorsinsert[] = "veuillez ajouter une url d'image";
    }
    if (empty($description)) {
        $errorsinsert[] = "Veuillez ajouter une description";
    }
    //vérifie si l'email existe déjà
    $dbh = connectDB();
    $connexion = $dbh->prepare('SELECT * FROM products where name= :name');
    $connexion->execute([
        ":name" => $name,
    ]);
    $resultname = $connexion->fetchAll();
    if ($resultname) {
        $errorsinsert[] = "Pokémon déjà existant";
    }
    if (empty($errorsinsert)) {
        $dbh = connectDB();
        $connexion = $dbh->prepare('INSERT INTO products VALUES (NULL, :name, :price, :category_id, :img, :description )');
        $connexion->execute([
            ":name" => $name,
            ":price" => $price,
            ":category_id" => $category_id,
            ":img" => $img,
            ":description" => $description,
        ]);
        $results = $connexion->fetchAll();
    }
}
?>
<?php foreach ($resultuser as $result) { ?>
    <div class="card m-auto">
        <p class='text-center'><?= $result['username'] ?></p>
        <div class="card-body d-flex">
            <a class="btn btn-primary" href="deleteuser.php?id=<?= $result['id'] ?>">Supprimer le profil</a>
        </div>
    </div>
<?php } ?>
<form class="formaddproduct" method="POST">
    <div class="form-group">
        <label class="nametext">Nom du Pokémon</label>
        <input type="text" class="form-control" name="name">
    </div>
    <div class="form-group">
        <label class="pricetextpokemon">Prix du Pokémon</label>
        <input type="number" class="form-control" name="price" step="any">
    </div>
    <div class="form-group">
        <label class="typechoice">Choissisez le type du Pokémon</label>
        <select class="custom-select" name="category_id">
            <option selected>Choissisez un type</option>
            <option value="1">feu</option>
            <option value="2">eau</option>
            <option value="3">acier</option>
            <option value="4">dragon</option>
            <option value="5">electrik</option>
            <option value="6">vol</option>
        </select>
    </div>
    <div class="form-group">
        <label class="imgpokemontext">Ajouter une Photo(url de la photo)</label>
        <input type="url" class="form-control" name="img">
    </div>
    <div class="form-group">
        <label class="describetext">Description du Pokémon</label>
        <textarea class="form-control" aria-label="With textarea" name="description"></textarea>
    </div>
    <button type="submit" class="btn btn-primary mb-4">Valider</button>
    <?php
    if (!empty($errorsinsert)) {
        echo '<div class="alert alert-danger mt-4" role="alert">';
        echo implode("<br>", $errorsinsert);
        echo '</div>';
    }
    ?>
</form>
<div class="card-deck">
    <?php foreach ($resultats as $resultat => $resultproduct) {
        $resulttype = $resultstype[$resultat];
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
                    <button type="button" class="btn btn-primary mt-4 editBtn" data-toggle="modal" data-target="#exampleModal" data-id="<?= $resultproduct['id'] ?>">Modifier les infos</button>
                    <a class="btn btn-primary" href="deletepoke.php?id=<?= $resultproduct['id'] ?>">Supprimer le pokémon</a>
                    <script type="text/javascript">
                        $(".editBtn").click(function() {
                            console.log($(this).data("id"));
                            $("#itemId").val($(this).data("id"));
                        })
                    </script>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="formaddproduct" method="POST">
                <script>
                    $('#myModal').on('show.bs.modal', function(e) {
                        $(this).find('.modal-body').html('   <div class="form-group"><label class="col-sm-3 control-label">ID</label><div class="col-sm-9"><input type="text" value = ' + e.relatedTarget.id + ' class="form-control" id="person_id" name="person_id" readonly="readonly"></div></div>          <div class="form-group"> <label class="col-sm-3 control-label">Date</label><div class="col-sm-9"><input type="date" readonly="readonly" class="form-control" id="cedula_date" value="<?php echo date("Y-m-d"); ?>" name="cedula_date"></div></div>           <div class="form-group"> <label class="col-sm-3 control-label">Cedula Number</label><div class="col-sm-9"><input type="number" class="form-control" id="cedula_number" name="cedula_number"/></div></div>');
                    })
                </script>
                <input type="hidden" id="itemId" name="itemId" value="">
                <div class="form-group">
                    <label class="nametext">Changer le nom du Pokémon</label>
                    <input type="text" class="form-control" name="nameModal">
                </div>
                <div class="form-group">
                    <label class="pricetextpokemon"> Changer le Prix du Pokémon</label>
                    <input type="number" class="form-control" name="priceModal">
                </div>
                <div class="form-group">
                    <label class="typechoice">Changer le type du Pokémon</label>
                    <select class="custom-select" name="category_idModal">
                        <option selected>Choissisez un type</option>
                        <option value="1">feu</option>
                        <option value="2">eau</option>
                        <option value="3">acier</option>
                        <option value="4">dragon</option>
                        <option value="5">electrik</option>
                        <option value="6">vol</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="imgpokemontext">Changer la Photo(url de la photo)</label>
                    <input type="url" class="form-control" name="imgModal">
                </div>
                <div class="form-group">
                    <label class="describetext">Changer la description Pokémon</label>
                    <textarea class="form-control" aria-label="With textarea" name="descriptionModal"></textarea>
                </div>
                <button type="submit" class="btn btn-primary mb-4">Valider</button>
                <?php
                if (!empty($errors)) {
                    echo '<div class="alert alert-danger mt-4" role="alert">';
                    echo implode("<br>", $errors);
                    echo '</div>';
                }
                ?>
            </form>
        </div>
    </div>
</div>