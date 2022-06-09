<?php
/**
 * HOME PAGE CONTROLLER
**/

// Models request
require_once 'services/render.php';
require_once "models/Session.php";
require_once "models/Product.php";

// User session starting
Session::start();

// Page title
$pageTitle = "Accueil";
$pagePath = "home";

// Classes instanciation
$productM = new Product;

// Calling methods from classes
$products = $productM->getAllProduct();

// View
render(__DIR__."/views/$pagePath", compact('pageTitle', 'products'));