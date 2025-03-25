<?php

namespace core;
/**
 * BaseModel Abstract Class
 * 
 * Provides core database operations using PDO.
 * All model classes should extend this base class.
 */
abstract class BaseModel
{
    /** @var \PDO Database connection */
    protected $pdo;
    
    /** @var string Database table name */
    protected $table;

    /**
     * Initialize database connection
     */

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    /**
     * Executes a SQL query with parameters
     * 
     * @param string $sql SQL query
     * @param array $params Parameters for binding
     * @return \PDOStatement
     */
    protected function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue(
                is_string($key) ? $key : $key + 1,
                $value,
                $this->getParamType($value)
            );
        }
        
        $stmt->execute();
        return $stmt;
    }

    /**
     * Retrieves all records from the database
     * 
     * @param array $queryParams Optional parameters for WHERE conditions
     * @return array
     */
    public function all(array $queryParams = [])
    {
        $where = '';
        $params = [];

        if (!empty($queryParams)) {
            $conditions = [];
            foreach ($queryParams as $field => $value) {
                $conditions[] = "$field = ?";
                $params[] = $value;
            }
            $where = ' WHERE ' . implode(' AND ', $conditions);
        }

        $sql = "SELECT * FROM {$this->table}{$where}";
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Retrieves a single record by ID
     * 
     * @param int $id
     * @return array|null
     */
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->query($sql, [$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Inserts a new record into the database
     * 
     * @param array $data
     * @return int ID of the newly inserted record
     */
    public function create(array $data)
    {
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$this->table} ($fields) VALUES ($placeholders)";
        $this->query($sql, array_values($data));
        
        return $this->pdo->lastInsertId();
    }

    /**
     * Updates a record in the database
     * 
     * @param int $id
     * @param array $data
     * @return int Number of affected rows
     */
    public function update($id, array $data)
    {
        $set = implode(', ', array_map(function($field) {
            return "$field = ?";
        }, array_keys($data)));

        $sql = "UPDATE {$this->table} SET $set WHERE id = ?";
        $params = array_merge(array_values($data), [$id]);
        
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    /**
     * Deletes a record from the database
     * 
     * @param int $id
     * @return int Number of affected rows
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->query($sql, [$id]);
        return $stmt->rowCount();
    }

    /**
         * Determina el tipo de parámetro PDO
     * 
     * @param mixed $value
     * @return int Constante PDO::PARAM_*
     */
    private function getParamType($value)
    {
        if (is_int($value)) return \PDO::PARAM_INT;
        if (is_bool($value)) return \PDO::PARAM_BOOL;
        if (is_null($value)) return \PDO::PARAM_NULL;
        return \PDO::PARAM_STR;
    }
}