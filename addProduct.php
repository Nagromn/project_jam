<?php
/**
 * ADD PRODUCT CONTROLLER
 *
**/

// Models request
require_once 'services/render.php';
require_once "models/Session.php";
require_once "models/User.php";
require_once "models/Product.php";
require_once "models/Category.php";
require_once "models/Upload.php";

// User session starting
Session::start();

// Page title
$pageTitle = "Nouvelle annonce";
$pagePath = "add.product";

// Upload configuration
$folderName = $_SESSION['auth']['username'];
$targetDir = "uploads/users/$folderName/";

// Date form
date_default_timezone_set('Europe/Paris');
$date = date('Y-m-d H:i:s');

// Class instanciation
$productM = new Product;
$categoriesM = new Category;
$uploadFile = new Upload;

// Find all categories from table 'category'
$categories = $categoriesM->findAll();

if(!empty($_POST)){
      // Extract POST
      extract($_POST);
      // Create new folder with username and contains user's files upload
      $dirExist = is_dir($targetDir);
      if(!$dirExist){
            mkdir("$targetDir");
            chmod("$targetDir", 0755);
      }

      $id = $_SESSION['auth']['id'];
      $categories = $categoriesM->findAll();
      // Insert new data into 'products' table 
      $products = $productM->insert(
            [
                  ':username' => $id,
                  ':category_id' => $category_id,
                  ':product_name' => $product_name,
                  ':description' => $description,
                  ':status' => $status,
                  ':price' => $price,
                  ':date' => $date
            ]
      );

      // Counter settings for loop below
      $counter = count($_FILES['userfiles']['name']);
      // Input 'userfiles[]' loop
      for($i = 0; $i < $counter; $i++){
            $fileName = basename($_FILES['userfiles']['name'][$i]);
            $targetFilePath = $targetDir.$fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowTypes = array('jpg','png','jpeg');

            if(in_array($fileType, $allowTypes) && $counter <= 3){
                  // Move uploaded files into user's folder on server data
                  if(move_uploaded_file($_FILES['userfiles']['tmp_name'][$i], $targetFilePath)){
                        // Insert into table 'uploads'
                        $uploadFile->insert(
                              [
                                    ':product_id' => $products,
                                    ':file_location' => $targetFilePath,
                                    ':uploaded_on' => $date
                              ]
                        );
                        // Display adding product message success
                        $_SESSION['success'] = "Votre annonce a été ajoutée avec succés !";
                        // Lead to user.profile page
                        // header('Location: userProfile.php');
                  }
            }else{
                  $_SESSION['error'] = "Erreur lors de l'enregistrement de votre annonce. Veuillez choisir 3 images maximum avec un format valide (JPG, JPEG ou PNG).";
                  header('Location: addProduct.php');
                  exit;
            }
      }
}

// View
render(__DIR__."/views/$pagePath", compact('pageTitle', 'categories'));