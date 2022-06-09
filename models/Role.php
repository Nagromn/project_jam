<?php
// Request
require_once 'Model.php';

class Role extends Model
{
      protected $table = 'roles';

      // Insert new role method
      public function insert(array $params): void {
            try {
                  $request = $this->database->prepare(
                        "INSERT INTO {$this->table}(`name`)
                        VALUES (:role)"
                  );
                  $request->execute($params);
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  exit;
            }
      }

      // Update role method
      public function updateRole(string $id, string $role){
            try {
                  $request = $this->database->prepare(
                        "UPDATE {$this->table}
                        SET name = :name
                        WHERE id = :id"
                  );
                  $request->execute(
                        [     
                              ':id' => $id,
                              ':name' => $role
                        ]
                  );
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
      }
}