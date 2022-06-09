<?php
// Requête Models
require_once "models/Session.php";
require_once "models/Upload.php";

// Démarrage de session
Session::start();

// Page title
$pageTitle = "";
$pagePath = 'update.product';

//Instanciation des classes
$uploadM = new Upload;

// Deleting user from database
$id = $_GET['id'];
$uploadM->deleteUploads($id);

// Display deleting message success
$_SESSION['success'] = "Les images ont été supprimées avec succés !";

// Redirection
header('Location: updateProduct.php?id='.$id);