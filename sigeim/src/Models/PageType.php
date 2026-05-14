<?php

namespace App\Models;

class PageType extends BaseModel {
    protected $table = 'page_types';

    /**
     * @property int(11) id
     * @property varchar(50) name
     */

    public function create($name) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (name) VALUES (?)");
        if ($stmt->execute([$name])) {
            return $this->db->lastInsertId();
        }
        return false;
    }
}
