<?php
/**
 * MESSAGE PAGE CONTROLLER
**/

// Models request
require_once 'services/render.php';
require_once "models/Session.php";
require_once "models/Messenger.php";

// User session starting
Session::start();

// Page title
$pageTitle = "Message";
$pagePath = 'message.display.reply';

// Classes instanciation
$messengerM = new Messenger;

// Variable
$id = $_GET['id'];

// Calling methods from classes
$message = $messengerM->findById(intval($id));

// View
render(__DIR__."/views/$pagePath", compact('pageTitle', 'message', 'id'));