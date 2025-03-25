<?php

namespace models;

use core\BaseModel;

class UserModel extends BaseModel
{
    protected $table = 'users';

    /**
     * Find user by email
     * 
     * @param string $email User email
     * @return array|null User data or null if not found
     */
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $stmt = $this->query($sql, [$email]);
        return $stmt->fetch() ?: null;
    }

    public function getActiveUsers()
    {
        $sql = "SELECT * FROM {$this->table} WHERE active = 1";
        return $this->query($sql)->fetchAll();
    }
}