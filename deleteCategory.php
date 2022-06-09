<?php
// Requête Models
require_once "models/Session.php";
require_once "models/Category.php";

// Démarrage de session
Session::start();

// Page title
$pageTitle = "";
$pagePath = 'admin.panel';

// Display deleting message success
$_SESSION['success'] = "La catégorie a été supprimée avec succés !";

//Instanciation des classes
$category = new Category;

// Deleting category from database
$id = $_GET['id'];
$category->delete($id);

// Redirection
header('Location: adminPanel.php' . '#category');
