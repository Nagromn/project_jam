<?php
/**
 * PRODUCT PAGE CONTROLLER
**/

// Models request
require_once 'services/render.php';
require_once "models/Session.php";
require_once "models/Product.php";

// User session starting
Session::start();

// Page title
$pageTitle = "Annonce";
$pagePath = "product.page";

// Classes instanciation
$productM = new Product;

// Variable
$id = $_GET['id'];

// Calling methods from classes
$product = $productM->getProductId(intval($id));

// View
render(__DIR__."/views/$pagePath", compact('pageTitle', 'product', 'id'));