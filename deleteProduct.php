<?php
// Requête Models
require_once "models/Session.php";
require_once "models/Product.php";

// Démarrage de session
Session::start();

// Page title
$pageTitle = "";
$pagePath = 'admin.panel';

// Display deleting message success
$_SESSION['success'] = "L'annonce a été supprimée avec succés !";

//Instanciation des classes
$product= new Product;

// Deleting user from database
$id = $_GET['id'];
$product->delete($id);

// Redirection
if(Session::isConnected() && $_SESSION['auth']['role'] == 2){
      header('Location: adminPanel.php');
      exit;
}else{
      header('Location: userProfile.php');
      exit;
}