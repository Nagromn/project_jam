<?php
// Request
require_once 'Model.php';

class Messenger extends Model
{
      protected $table = 'messages';

      // Insert new message method
      public function insert(array $params): void
      {
            try {
                  $request = $this->database->prepare(
                        "INSERT INTO {$this->table}(`sender_id`, `receiver_id`, `title`, `content`, `created_date`)
                        VALUES (:sender_id, :receiver_id, :title, :content, :date)"
                  );
                  $request->execute($params);
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
      }

      // Find messages by sender id
      public function getMessagesBySenderId(string $id)
      {
            try {
                  $request = $this->database->prepare(
                        "SELECT users.username as username, messages.id as id, sender_id, receiver_id, content, title, messages.created_date
                        FROM {$this->table}
                        INNER JOIN users ON messages.sender_id = users.id
                        WHERE :id = $id
                        ORDER BY created_date DESC"
                  );
                  $request->execute(
                        [
                              ':id' => $id
                        ]
                  );
                  $result = $request->fetchAll();
                  return $result;
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
      }

      // Find messages by receiver id
      public function getMessagesByReceiverId(string $id)
      {
            try {
                  $request = $this->database->prepare(
                        "SELECT users.username as username, messages.id as id, sender_id, receiver_id, content, title, messages.created_date
                        FROM {$this->table}
                        INNER JOIN users ON messages.receiver_id = users.id
                        WHERE :id = $id
                        ORDER BY created_date DESC"
                  );
                  $request->execute(
                        [
                              ':id' => $id
                        ]
                  );
                  $result = $request->fetchAll();
                  return $result;
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
      }
}
