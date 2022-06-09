<?php
/**
 * UPDATE CATEGORY CONTROLLER
 * 
**/

// Models request
require_once 'services/render.php';
require_once "models/Session.php";
require_once "models/Category.php";

// User's session starting
Session::start();

// Page title
$pageTitle = "Catégorie update";
$pagePath = 'update.category';

// Global variable
$id = $_GET['id'];

// Class instanciation
$categoryM = new Category;

if(empty($_POST)){
      // Find role by id method
      $category = $categoryM->findById($id);
}else{
      // Local variables
      $id = $_GET['id'];
      $category = $_POST['name'];
      // Update role data method
      $categoryM->updateCategory($id, $category);
      // Display updating message success
      $_SESSION['success'] = "Catégorie modifiée avec succés !";
      // User redirection to admin panel page
      header('Location: adminPanel.php');
      exit;
}

// View
render(__DIR__."/views/$pagePath", compact('pageTitle', 'category', 'id'));