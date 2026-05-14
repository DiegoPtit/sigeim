<?php

namespace App\Models;

class PrintJob extends BaseModel {
    protected $table = 'print_jobs';

    /**
     * @property int(11) id
     * @property varchar(255) document_name
     * @property varchar(255) file_path
     * @property varchar(10) file_type
     * @property int(11) department_id
     * @property enum('pendiente','en_cola','imprimiendo','completado','error','cancelado') status
     * @property int(11) total_copies_sum
     * @property timestamp created_at
     * @property timestamp updated_at
     */

    public function create($document_name, $file_path, $file_type, $department_id, $status, $total_copies_sum) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (document_name, file_path, file_type, department_id, status, total_copies_sum) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$document_name, $file_path, $file_type, $department_id, $status, $total_copies_sum])) {
            return $this->db->lastInsertId();
        }
        return false;
    }
}
