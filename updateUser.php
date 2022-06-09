<?php

/**
 * UPDATE USER CONTROLLER
 **/

// Models request
require_once 'services/render.php';
require_once "models/Session.php";
require_once "models/User.php";

// User's session starting
Session::start();

// Page title
$pageTitle = "Utilisateur update";
$pagePath = 'update.user';

// Global variable
$id = $_GET['id'];

// Class instanciation
$userM = new User;

// If empty POST =>
if (empty($_POST)) {
      // Find user by id method
      $user = $userM->findById(intval($id));
      // Else, display all current user personal data
} else {
      // Variables
      $id = $_GET['id'];
      $email = $_POST['email'];
      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
      $birthdate = $_POST['birthdate'];
      $phone = $_POST['phone'];
      $address = $_POST['address'];
      $city = $_POST['city'];
      $zipcode = $_POST['zipcode'];
      // Format phone number
      if (preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $phone)) {
            $meta_carac = array("-", ".", " ");
            $phone = str_replace($meta_carac, "", $phone);
            // $phone = chunk_split($phone, 2, "\r");
      }
      // Update user data method
      $userM->updateUser(
            $email,
            $firstname,
            $lastname,
            $birthdate,
            $phone,
            $address,
            $city,
            $zipcode,
            intval($id)
      );
      // Updating new data in active session after using update method
      $_SESSION['auth']['email'] = $email;
      $_SESSION['auth']['firstname'] = $firstname;
      $_SESSION['auth']['lastname'] = $lastname;
      $_SESSION['auth']['birthdate'] = $birthdate;
      $_SESSION['auth']['phone'] = $phone;
      $_SESSION['auth']['address'] = $address;
      $_SESSION['auth']['city'] = $city;
      $_SESSION['auth']['zipcode'] = $zipcode;

      // User redirection to user profile page
      header('Location: userProfile.php');
      // Display updating message success
      $_SESSION['success'] = "Vos données personnelles ont été modifiées avec succés !";
      exit;
}

// View
render(__DIR__ . "/views/$pagePath", compact('pageTitle', 'user', 'userM', 'id'));
