<?php

namespace App\Models;

class Department extends BaseModel {
    protected $table = 'departments';

    /**
     * @property int(11) id
     * @property varchar(100) name
     * @property timestamp created_at
     * @property timestamp updated_at
     */

    public function create($name) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (name) VALUES (?)");
        if ($stmt->execute([$name])) {
            return $this->db->lastInsertId();
        }
        return false;
    }
}
