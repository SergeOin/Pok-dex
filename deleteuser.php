<?php
session_start();
require_once 'db.php';
$id = $_GET['id'];
$dbh = connectDB();
$connexion = $dbh->prepare('DELETE from users where :id = id');
$connexion->execute([
    ":id" => $id,
]);
$result = $connexion->fetchAll();
header('location:backadmin.php');
exit;