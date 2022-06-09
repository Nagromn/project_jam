<?php

/**
 * LOGIN CONTROLLER
 * // Correspond au controlleur de l'affichage du formulaire de connexion des utilisateurs
 **/

// Models request
require_once 'services/render.php';
require_once "models/User.php";
require_once "models/Session.php";
require_once "models/Product.php";

// Page title
$pageTitle = "Login";
$pagePath = 'login';

// Classes instanciation
$auth = new User;
$product = new Product;

try {
      // If registered user =>
      if (!empty($_POST)) {
            extract($_POST);
            $user = $auth->findUserByEmail($email);
            // If not registered user =>
            if (empty($user)) {
                  throw new DomainException("Ce nom d'utilisateur n'existe pas");
            } else {
                  // If right password, user log in =>
                  if (password_verify($password, $user['password'])) {
                        // Session starting
                        Session::start();
                        $productM = $product->getProductsByUserId($user['id']);
                        Session::init(
                              // Initialisation user's personnal data
                              $user['id'],
                              $user['email'],
                              $user['username'],
                              $user['firstname'],
                              $user['lastname'],
                              $user['birthdate'],
                              $user['phone'],
                              $user['address'],
                              $user['city'],
                              $user['zipcode'],
                              $user['role_id']
                        );
                        // Empty notifications history
                        Session::setError();
                        echo json_encode(['auth' => $user]);
                        // User redirection to home page
                        header('Location: home.php');
                        exit;
                  } else {
                        // If wrong user's password =>
                        throw new DomainException("Mot de passe erroné");
                  }
            }
      }
} catch (DomainException $e) {
      echo $e->getMessage();
}

// View
render(__DIR__ . "/views/$pagePath", compact('pageTitle'));
