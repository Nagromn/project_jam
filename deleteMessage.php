<?php
// Requête Models
require_once "models/Session.php";
require_once "models/Messenger.php";

// Démarrage de session
Session::start();

// Page title
$pageTitle = "";
$pagePath = 'user.profile';

// Display deleting message success
$_SESSION['success'] = "Le message a été supprimée avec succés !";

//Instanciation des classes
$messenger = new Messenger;

// Deleting category from database
$id = $_GET['id'];
$messenger->delete($id);

// Redirection
header('Location: userProfile.php');