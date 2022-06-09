<?php
// Requête Models
require_once "models/Session.php";
require_once "models/Role.php";

// Démarrage de session
Session::start();

// Page title
$pageTitle = "";
$pagePath = 'admin.panel';

// Display deleting message success
$_SESSION['success'] = "Le rôle a été supprimée avec succés !";

//Instanciation des classes
$role = new Role;

// Deleting user from database
$id = $_GET['id'];
$role->delete($id);

// Redirection
header('Location: adminPanel.php');