<?php
// Import du model
require_once '../models/User.php';
require_once '../services/Session.php';

// Init instance of Use
$userM = new User;

// var_dump($_GET);
// echo "It's all right";

// test Get for search, refresh, logout
if(isset($_GET) && !empty($_GET)) {
    if (array_key_exists('action', $_GET) && !empty($_GET['action']))
    {
        switch ($_GET['action']) {
            case 'findAll':
                echo json_encode($userM->findAll());
                break;

            case 'search':
                // test si la recherche est possible
                if (array_key_exists('word', $_GET)
                    && !empty($_GET['word'])
                    && strlen($_GET['word']) > 1)
                {
                    echo json_encode($userM->findByName($_GET['word']));
                }
                break;
        }
    }
}

// test Post for all others forms
if (isset($_POST) && !empty($_POST))
{
    /* var_dump($_POST); */
    //test contents
    foreach($_POST as $name => $input) {
        // test nickName - regex
        $regNickName = '/[a-zA-Z]{4,15}/gm';
        //var_dump(preg_match($regNickName, $input));
        try {
            // if($name === 'nickName' && preg_match($regNickName, $input) !== 1) {
            if($name === 'nickName' && empty($input)) {
                // Lever d'une erreur, champ vide
                throw new DomainException("Pseudo invalide");
            }

            // test email - filter_var
            if($name === 'email' && !filter_var($input, FILTER_VALIDATE_EMAIL)) {
                // Lever d'une erreur, champ incorrect
                throw new DomainException("Email invalide");
            }

            // test password - regex
            if($name === 'password' && empty($input)) {
                // Lever d'une erreur, champ vide
                throw new DomainException("Password invalide");
            }
        } catch (DomainException $e) {
            echo $e->getMessage();
            exit;
        }

    }

    // Treatment
    extract($_POST);
    // Define form action
    switch ($action) {
        case 'insert':
            // Enregistrement de mon contact
            $userM->insert(
                [
                    ':nickName' => $nickName,
                    ':email'    => $email,
                    ':password' => password_hash($password, PASSWORD_DEFAULT)
                ]
            );
            break;

        case 'auth':
            // Authentification
            // Login
            // Récupération de l'utilisateur correspondant au nom d'utilisateur
            $user = $userM->findByEmail($email);
            try {
                if (empty($user)) {
                    // Si l'utilisateur est vide => L'utilisateur n'existe pas en base de données
                    // => On renvoie l'utilisateur sur le formulaire
                    // #TODO to Session
                    throw new DomainException("Ce nom d'utilisateur n'existe pas");
                } else {
                    // L'utilisateur existe bien => on vérifie si son mot de passe correspond à celui qui a été tapé
                    // Est-ce que le mot de passe du formulaire correspond à celui en base de données
                    if (password_verify($password, $user['password'])) {
                        // Le mot de passe correspond => connexion de l'utilisateur
                        // => Enregistrement des informations de l'utilisateur dans la session
                        Session::start();
                        Session::init($user['name'], $email);
                        Session::setError(); // Vider l'historique de notifs
                        // Une fois que l'utilisateur est authentifié, on le renvoi dans le callback
                        echo json_encode(['user' => $user]);
                    } else {
                        // Le mot de passe est erroné => erreur => on renvoie l'utilisateur sur le formulaire
                        // #TODO to Session
                        throw new DomainException("Mot de passe erroné");
                    }
                }
            } catch (DomainException $e) {
                echo $e->getMessage();
            }
            break;
        case 'delete':
            var_dump($users);die;
            $userM->delete($users);
            break;
    }
}
