<?php

namespace App\Models;

class PrintCopy extends BaseModel {
    protected $table = 'print_copies';

    /**
     * @property int(11) id
     * @property int(11) print_job_id
     * @property int(11) quantity
     * @property enum('blanco_negro','color') color_mode
     * @property enum('vertical','horizontal') orientation
     * @property enum('original','reducida','agrandada') scale
     * @property varchar(50) specific_pages
     * @property text notes
     */

    public function create($print_job_id, $quantity, $color_mode, $orientation, $scale, $specific_pages, $notes) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (print_job_id, quantity, color_mode, orientation, scale, specific_pages, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$print_job_id, $quantity, $color_mode, $orientation, $scale, $specific_pages, $notes])) {
            return $this->db->lastInsertId();
        }
        return false;
    }
}
