<?php

/**
 * USER PROFILE CONTROLLER
 **/

// Models request
require_once 'services/render.php';
require_once "models/Session.php";
require_once "models/Product.php";
require_once "models/Messenger.php";
require_once "models/User.php";

// User's session starting
Session::start();
     
// Page title
$pageTitle = "Profile";
$pagePath = 'user.profile';

// Session variable
$id = $_SESSION['auth']['id'];

// Class instanciation
$productM = new Product;
$messengerM = new Messenger;
// $userM = new User;

// Calling methods from classes
$products = $productM->getProductsByUserId($id);
// $sendedMsg = $userM->getMessagesById();
$sendedMsg = $messengerM->getMessagesBySenderId($id);
// var_dump($messengerM->getMessagesBySenderId($id));
// die;
$receivedMsg = $messengerM->getMessagesByReceiverId($id);

// View
render(__DIR__ . "/views/$pagePath", compact('pageTitle', 'products', 'sendedMsg', 'receivedMsg'));
