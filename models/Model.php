<?php

abstract class Model
{
    protected $database;
    protected $table;

    public function __construct() {
        try {
            $this->database = new PDO(
                'mysql:host=db.3wa.io;dbname=morganwattier_projet_final;charset=utf8',
                'morganwattier',
                'bafe9b24c649fda26a098f5b0ea59e9e',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Insert data method
    abstract public function insert(array $params);

    // Search all data method
    public function findAll(): ?array {
        try {
            $request = $this->database->query(
                "SELECT *
                FROM {$this->table}"
            );
            $result = $request->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
        return $result ?? [];
    }

    // Delete method
    public function delete(string $id) :void{
        try {
            $request = $this->database->prepare(
                "DELETE
                FROM {$this->table}
                WHERE id = ?"
            );
            $request->execute([$id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }

    // Search by id method
    public function findById(string $id) {
        try {
            $request = $this->database->prepare(
                "SELECT *
                FROM {$this->table}
                WHERE id = :id"
            );
            $request->execute([':id' => $id]);
            $result = $request->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
        return $result;
    }

    // Count data row method
    public function count() {
        try {
            $request = $this->database->prepare(
                "SELECT COUNT(id) as count
                FROM {$this->table}"
            );
            $request->execute();
            $result = $request->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
        return $result['count'];
    }
}