<?php
/**
 * UPDATE PRODUCT CONTROLLER
**/

// Models request
require_once 'services/render.php';
require_once "models/Session.php";
require_once "models/Product.php";
require_once "models/Category.php";
require_once "models/Upload.php";

// User's session starting
Session::start();

// Page title
$pageTitle = "Annonce update";
$pagePath = 'update.product';

// Upload configuration
$folderName = $_SESSION['auth']['username'];
$targetDir = "uploads/users/$folderName/";

// Date form
date_default_timezone_set('Europe/Paris');
$date = date('Y-m-d H:i:s');

// Global variable
$id = $_GET['id'];

// Class instanciation
$productM = new Product;
$categoryM = new Category;
$uploadFile = new Upload;

// Calling methods
$categories = $categoryM->findAll();
$product = $productM->getProductId(intval($id));

if(!empty($_POST)){
      extract($_POST);
      $counter = count($_FILES['userfiles']['name']);
      $id = $_POST['id'];
      $product_name = $_POST['product_name'];
      $category = $_POST['category_id'];
      $description = $_POST['description'];
      $status = $_POST['status'];
      $price = $_POST['price'];
      // Update product method
      $productM->updateProduct(
            $id,
            $category,
            $product_name,
            $description,
            $status,
            $price
      );

      // Input 'userfiles[]' loop
      for($i = 0; $i < $counter ;$i++){
            $fileName = basename($_FILES['userfiles']['name'][$i]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowTypes = array('jpg','png','jpeg');
            // If fileType and image format 'OK' =>
            if(in_array($fileType, $allowTypes)){
                  // Move uploaded files into user's folder on server data
                  if(move_uploaded_file($_FILES['userfiles']['tmp_name'][$i], $targetFilePath)){
                        // Upload insert into table 'uploads'
                        $uploadFile->insert(
                              [
                                    ':product_id' => $id,
                                    ':file_location' => $targetFilePath,
                                    ':uploaded_on' => $date
                              ]
                        );
                  }
            }else{
                 $_SESSION['error'] = "Erreur lors de l'enregistrement de votre annonce. Veuillez choisir un format d'image valide (JPG, JPEG ou PNG).";
            }
      }
      // User redirection to user profile page
      header('Location: userProfile.php');
      // Display updating message success
      $_SESSION['success'] = "Annonce modifiée avec succés !";
}

// View
render(__DIR__."/views/$pagePath", compact('pageTitle', 'categories', 'product', 'id'));