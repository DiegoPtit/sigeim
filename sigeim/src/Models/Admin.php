<?php

namespace App\Models;

class Admin extends BaseModel {
    protected $table = 'admins';

    /**
     * @property int(11) id
     * @property varchar(50) username
     * @property varchar(255) password
     * @property varchar(100) name
     * @property enum('superadmin','operador') role
     * @property timestamp created_at
     * @property timestamp last_login
     */

    public function create($username, $password, $name, $role, $last_login) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (username, password, name, role, last_login) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$username, password_hash($password, PASSWORD_BCRYPT), $name, $role, $last_login])) {
            return $this->db->lastInsertId();
        }
        return false;
    }
}
