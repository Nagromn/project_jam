<?php

/**
 * Classe représentant la session php $_SESSION
 *
 * liste de fonctionnalitées :
 *      - start(): void // Démarrage de la session, afin de pouvoir l'utiliser
 *      - destroy(): void // Destruction de la session, afin de déconnecter le user
 *      - init(id, nom, email, ... (role) ): void // Remplissage de la session avec les infos du user
 *      - isConnected(): bool // méthode retournerai un booléen pour dire si oui ou non quelqu'un est connecté
 *      - getLogged(): array // méthode retournerai les infos du user connecté
 */

class Session
{

      public static function start(): void
      {
            if (session_status() === PHP_SESSION_NONE) {
                  session_start();
            }
      }

      public static function destroy(): void
      {
            $_SESSION['auth'] = [];
            unset($_SESSION['auth']);
            // session_destroy();
      }

      public static function init(
            int $id,
            string $email,
            string $username,
            string $firstname,
            string $lastname,
            string $birthdate,
            string $phone,
            string $address,
            string $city,
            string $zipcode,
            string $role
      ): void {
            $_SESSION['auth'] =
                  [
                        'id' => intval($id),
                        'email' => $email,
                        'username' => $username,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'birthdate' => $birthdate,
                        'phone' => $phone,
                        'address' => $address,
                        'city' => $city,
                        'zipcode' => $zipcode,
                        'role' => $role
                  ];
      }

      public static function isConnected(): bool
      {
            return isset($_SESSION['auth']) ?? false;
      }

      public static function getLogged()
      {
            // Usage de l'opérateur static '::'
            // Pour utiliser des props ou méthodes static au sein de la class elle-même
            // il faut utiliser 'self' ou le nom de la classe elle-même, ici 'SessionManager' devant l'opérateur
            return self::isConnected() ? $_SESSION['auth'] : false;
      }

      public static function setError(string $error = null): void
      {
            $_SESSION['error'] = $error;
      }

      public static function getError(): ?string
      {
            return isset($_SESSION['error']) ? $_SESSION['error'] : null;
      }
}
