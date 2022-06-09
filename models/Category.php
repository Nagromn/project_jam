<?php
// Request
require_once 'Model.php';

class Category extends Model
{
      protected $table = 'category';

      // Insert new category method
      public function insert(array $params)
      {
            try {
                  $request = $this->database->prepare(
                        "INSERT INTO {$this->table}(name)
                        VALUES (:name)"
                  );
                  $request->execute($params);
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
      }

      // Update category method
      public function updateCategory(string $id, string $category)
      {
            try {
                  $request = $this->database->prepare(
                        "UPDATE {$this->table}
                        SET name = :name
                        WHERE id = :id"
                  );
                  $request->execute(
                        [
                              ':id' => $id,
                              ':name' => $category
                        ]
                  );
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
      }
}
