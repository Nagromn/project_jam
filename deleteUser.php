<?php
/**
 * DELETE USER CONTROLLER
**/

// Models request
require_once "models/Session.php";
require_once "models/User.php";

// User session starting
Session::start();

// Page title
$pageTitle = "";
$pagePath = 'admin.panel';

// Display deleting message success
$_SESSION['success'] = "L'utilisateur a été supprimée avec succés !";

// Class instanciation
$user = new User;

// Variable
$id = $_GET['id'];

// Calling methods from classes
$user->delete($id);

// Redirection
header('Location: adminPanel.php');