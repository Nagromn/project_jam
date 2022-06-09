<?php

/**
 * REGISTER CONTROLLER
 * * // Correspond au controlleur de l'affichage du formulaire d'inscription pour les nouveaux utilisateurs
 **/

// Models request
require_once 'services/render.php';
require_once "models/Session.php";
require_once "models/User.php";

// User's session starting
Session::start();

// Date form
date_default_timezone_set('Europe/Paris');
$date = date('Y-m-d H:i:s');

// Page title
$pageTitle = "S'enregistrer";
$pagePath = 'register';

// Class instanciation
$addUsers = new User;

// If not empty form =>
if (!empty($_POST)) {
      // If email exists and not an empty field
      if (array_key_exists('email', $_POST) && !empty($_POST['email'])) {
            // Extract from $_POST
            extract($_POST);
            // Email checking
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  echo $message = "Entrez une adresse email valide";
            } else {
                  // Else, insert new data into the database
                  $addUsers->insert(
                        [
                              ':username' => $username,
                              ':email' => $email,
                              ':firstname' => $firstname,
                              ':lastname' => $lastname,
                              ':birthdate' => $birthdate,
                              ':phone' => $phone,
                              ':address' => $address,
                              ':city' => $city,
                              ':zipcode' => $zipcode,
                              ':password' => password_hash($password, PASSWORD_DEFAULT),
                              ':date' => $date
                        ]
                  );
            }
            // Home page redirection
            header('Location: home.php');
            $_SESSION['success'] = "Votre compte a bien été crée !";
            exit;
      }
}

// View
render(__DIR__ . "/views/$pagePath", compact('pageTitle'));
