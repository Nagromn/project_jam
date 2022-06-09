<?php
// Models request
require_once 'services/render.php';
require_once "models/Session.php";
require_once "models/Messenger.php";

// User's session starting
Session::start();

// Page title
$pageTitle = "Messenger";
$pagePath = 'message.display';

// Date form
date_default_timezone_set('Europe/Paris');
$date = date('Y-m-d H:i:s');

// Class instanciation
$messengerM = new Messenger;

if (!empty($_POST)){
      extract($_POST);
      $sender = $_SESSION['auth']['id'];
      $receiver = $_POST['id'];
      $messengerM->insert(
            [
                  'sender_id' => $sender,
                  'receiver_id' => $receiver,
                  'title' => $title,
                  'content' => $content,
                  'date' => $date
            ]
      );
      // Display updating message success
      $_SESSION['success'] = "Message envoyé !";
      header('Location: home.php');
      exit;
}

render(__DIR__."/views/$pagePath", compact('pageTitle'));