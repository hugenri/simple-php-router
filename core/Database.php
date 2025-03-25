<?php

namespace core;
/**
 * Database Singleton Class
 * 
 * Manages PDO database connection using Singleton pattern.
 * Reads credentials from environment variables.
 */
class Database
{
    /** @var Database|null Singleton instance */
    private static $instance = null;
    
    /** @var \PDO Database connection */
    private $pdo;

    /**
     * Private constructor - prevents direct instantiation
     * @throws \PDOException On connection failure
     */
    private function __construct()
    {
        try {
            $this->pdo = new \PDO(
                "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8",
                $_ENV['DB_USER'],
                $_ENV['DB_PASSWORD'],
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (\PDOException $e) {
            throw new \PDOException("Error de conexión: " . $e->getMessage());
        }
    }

    /**
     * Returns the singleton instance of the database
     * @return Database
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Returns the PDO database connection
     * @return \PDO
     */
    public function getConnection()
    {
        return $this->pdo;
    }

    /**
     * Prevents object cloning
     */
    private function __clone() {}
    public function __wakeup() {}
}