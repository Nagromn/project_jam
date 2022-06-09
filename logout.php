<?php
/**
 * LOGOUT CONTROLLER
 * // Correspond au controlleur de déconnexion
**/

// Models request
require_once "models/Session.php";

// User's session starting
Session::start();
// User's session logout
Session::destroy();

// User redirection to homepage
header('Location: home.php');