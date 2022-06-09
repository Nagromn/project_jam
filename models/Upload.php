<?php
// Request
require_once 'Model.php';

class Upload extends Model
{
      protected $table = 'uploads';

      // Insert new upload method
      public function insert(array $params) {
            try {
                  $request = $this->database->prepare(
                        "INSERT INTO {$this->table}(`product_id`, `file_location`, `uploaded_on`)
                        VALUES (:product_id, :file_location, :uploaded_on)"
                  );
                  $request->execute($params);
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
      }

      // Search product id method
      public function getUploadId(string $id) {
            try {
                  $request = $this->database->prepare(
                        "SELECT products.id as product_id, users.id as user_id, users.username, products.product_name, products.category_id, products.description, products.status, products.price, products.created_date, category.name, GROUP_CONCAT(`file_location` SEPARATOR ', ') AS files,
                        GROUP_CONCAT(`uploads`.`id` SEPARATOR ', ') AS upload
                        FROM {$this->table}
                        INNER JOIN users ON products.user_id = users.id
                        INNER JOIN category ON products.category_id = category.id
                        INNER JOIN uploads ON products.id = uploads.product_id
                        WHERE products.id = :id
                        GROUP BY products.id"
                  );
                  $request->execute(
                        [
                              ':id' => intval($id)
                        ]
                  );
                  $result = $request->fetch();
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
            return 
            $result;
      }

      // Delete method
    public function deleteUploads(string $id) :void{
      try {
          $request = $this->database->prepare(
              "DELETE
              FROM {$this->table}
              WHERE product_id = product_id"
          );
          $request->execute([$id]);
      } catch (PDOException $e) {
          echo $e->getMessage();
          die;
      }
  }
}