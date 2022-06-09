<?php
// Request
require_once 'Model.php';

class User extends Model
{
      protected $table = 'users';

      // Insert new user method
      public function insert(array $params): void
      {
            try {
                  if ($this->findUserByEmail($params[':email']))
                        throw new PDOException("Cet utilisateur existe déjà");

                  $request = $this->database->prepare(
                        "INSERT INTO {$this->table}(username, email, password, firstname, lastname, birthdate, phone, address, city, zipcode, created_date)
                        VALUES (:username, :email, :password, :firstname, :lastname, :birthdate, :phone, :address, :city, :zipcode, :date)"
                  );
                  $request->execute($params);
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  exit;
            }
      }

      // Find all users method
      public function findAllUsers()
      {
            try {
                  $request = $this->database->prepare(
                        "SELECT *
                        FROM {$this->table}
                        INNER JOIN roles ON users.role_id = roles.id"
                  );
                  $request->execute();
                  $result = $request->fetchAll();
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
            return $result;
      }

      // Find user by email method
      public function findUserByEmail(string $email)
      {
            try {
                  $request = $this->database->prepare(
                        "SELECT *
                        FROM {$this->table}
                        WHERE email = :email"
                  );
                  $request->execute([':email' => $email]);
                  $result = $request->fetch();
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
            return $result;
      }

      // Find user by username method
      public function findUserByUsername(string $username)
      {
            try {
                  $request = $this->database->prepare(
                        "SELECT username
                        FROM {$this->table}
                        WHERE username = :username"
                  );
                  $request->execute([':username' => $username]);
                  $result = $request->fetchAll();
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
            return $result ?? [];
      }

      // Find user by id method
      public function findUserById(string $id)
      {
            try {
                  $request = $this->database->prepare(
                        "SELECT id, username, email, firstname, lastname, birthdate, address, phone, city, zipcode
                        FROM {$this->table}
                        WHERE users.id = :id"
                  );
                  $request->execute(
                        [
                              ':id' => $id
                        ]
                  );
                  $result = $request->fetch();
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
            return $result;
      }

      // Update user method
      public function updateUser(
            string $email,
            string $firstname,
            string $lastname,
            string $birthdate,
            string $phone,
            string $address,
            string $city,
            string $zipcode,
            string $id
      ) {
            try {
                  $request = $this->database->prepare(
                        "UPDATE {$this->table}
                        SET 
                        email = :email,
                        firstname = :firstname, 
                        lastname = :lastname, 
                        birthdate = :birthdate, 
                        phone = :phone, 
                        address = :address, 
                        city = :city, 
                        zipcode = :zipcode
                        WHERE id = :id"
                  );
                  $request->execute(
                        array(
                              'email' => $email,
                              'firstname' => $firstname,
                              'lastname' => $lastname,
                              'birthdate' => $birthdate,
                              'phone' => $phone,
                              'address' => $address,
                              'city' => $city,
                              'zipcode' => $zipcode,
                              'id' => $id
                        )
                  );
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
      }

      // Find messages by sender id
      public function getMessagesById()
      {
            try {
                  $request = $this->database->prepare(
                        "SELECT users.username as username, messages.id as id, sender_id, receiver_id, content, title, messages.created_date
                        FROM {$this->table}
                        INNER JOIN users ON messages.sender_id = users.id
                        ORDER BY created_date DESC"
                  );
                  $request->fetchAll();
                  return $request;
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
      }
}
