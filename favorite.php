<?php
/**
 * FAVORITE CONTROLLER
 * 
**/

// Models request
require_once 'services/render.php';
require_once "models/Session.php";
require_once "models/Product.php";

// User's session starting
Session::start();

// Page title
$pageTitle = "Favoris";
$pagePath = 'favorite';

$productM = new Product;

$products = $productM->getAllProduct();

// View
render(__DIR__."/views/$pagePath", compact('pageTitle', 'products'));