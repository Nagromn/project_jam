<?php
// Request
require_once 'Model.php';

class Product extends Model
{
      protected $table = 'products';

      // Insert new product method
      public function insert(array $params){
            try {
                  $request = $this->database->prepare(
                        "INSERT INTO {$this->table}(`user_id`, `category_id`, `product_name`, `description`, `status`, `price`, `created_date`)
                        VALUES (:username, :category_id, :product_name, :description, :status, :price, :date)");
                  $request->execute($params);
                  return $this->database->lastInsertId();
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
      }

      // Search all products method
      public function getAllProduct() {
            try {
                  $request = $this->database->prepare(
                        "SELECT products.id AS id, users.username, products.user_id, products.category_id, category.name, products.product_name, products.description, products.status, products.price, products.created_date, GROUP_CONCAT(`file_location` SEPARATOR ', ') AS files
                        FROM {$this->table}
                        INNER JOIN users ON products.user_id = users.id
                        INNER JOIN category ON products.category_id = category.id
                        INNER JOIN uploads ON products.id = uploads.product_id GROUP BY id"
                  );
                  $request->execute();
                  $result = $request->fetchAll();
                  return $result;
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
      }

      // Search products by user's id method
      public function getProductsByUserId(string $id) {
            try {
                  $request = $this->database->prepare(
                        "SELECT products.id AS product_id, products.product_name, products.description, products.status, products.price, products.created_date, category.name, GROUP_CONCAT(`file_location` SEPARATOR ', ') AS files
                        FROM {$this->table}
                        INNER JOIN users ON products.user_id = users.id
                        INNER JOIN category ON products.category_id = category.id
                        INNER JOIN uploads ON products.id = uploads.product_id
                        WHERE users.id = :id
                        GROUP BY products.id"
                  );
                  $request->execute(
                        [
                              ':id' => intval($id)
                        ]
                  );
                  $result = $request->fetchAll();
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
            return 
            $result;
      }

      // Search product id method
      public function getProductId(string $id) {
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

      // Update products method
      public function updateProduct(string $id, string $category, string $product_name, string $description, string $status, string $price) {
            try {
                  $request = $this->database->prepare(
                        "UPDATE {$this->table}
                        SET category_id = :category_id, product_name = :product_name, description = :description, status = :status, price = :price
                        WHERE id = :id"
                  );
                  $request->execute(
                        [
                              ':id' => $id,
                              ':category_id' => $category,
                              ':product_name' => $product_name,
                              ':description' => $description,
                              ':status' => $status,
                              ':price' => $price
                        ]
                  );
            } catch (PDOException $e) {
                  echo $e->getMessage();
                  die;
            }
      }
}