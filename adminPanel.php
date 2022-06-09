<?php

/**
 * ADMIN PANEL CONTROLLER
 **/

// Models request
require_once 'services/render.php';
require_once "models/Session.php";
require_once "models/Product.php";
require_once "models/Category.php";
require_once "models/User.php";
require_once "models/Role.php";

// User's session starting
Session::start();

// Page title
$pageTitle = "Admin";
$pagePath = 'admin.panel';

// Class instanciation
$userM = new User;
$productM = new Product;
$categoriesM = new Category;
$roleM = new Role;

// Calling methods from classes
$users = $userM->findAllUsers();
$categories = $categoriesM->findAll();
$products = $productM->getAllProduct();
$roles = $roleM->findAll();

// Counting methods
$countUsers = $userM->count();
$countRoles = $roleM->count();
$countProducts = $productM->count();
$countCategories = $categoriesM->count();

// Session variable
$id = $_SESSION['auth']['id'];

// Calling method from class Product to get product_id
$product = $productM->getProductId(intval($id));

if (!empty($_POST['role'])) {
      extract($_POST);
      $roles = $roleM->findAll();
      $roleM->insert([':role' => $role]);
      header('Location: ' . $_SERVER['PHP_SELF'] . '#role');
      // Message display
      $_SESSION['success'] = "Nouveau rôle ajouté avec succés !";
      exit;
}
if (!empty($_POST['name'])) {
      extract($_POST);
      $categories = $categoriesM->findAll();
      $categoriesM->insert([':name' => $name]);
      header('Location: ' . $_SERVER['PHP_SELF'] . '#category');
      // Message display
      $_SESSION['success'] = "Nouvelle catégorie ajoutée avec succés !";
      exit;
}

// View
render(__DIR__ . "/views/$pagePath", compact(
      'pageTitle',
      'users',
      'products',
      'categories',
      'roles',
      'countUsers',
      'countRoles',
      'countProducts',
      'countCategories'
));
