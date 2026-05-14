<?php

require_once __DIR__ . '/../public/index.php';

use App\Services\Database;

/**
 * Script to synchronize (generate) Model classes from Database Tables
 */

$db = Database::getInstance();
$modelsDir = __DIR__ . '/../src/Models';

if (!is_dir($modelsDir)) {
    mkdir($modelsDir, 0755, true);
}

// Get all tables from the database
$tablesStmt = $db->query("SHOW TABLES");
$tables = $tablesStmt->fetchAll(PDO::FETCH_COLUMN);

foreach ($tables as $table) {
    $className = str_replace(' ', '', ucwords(str_replace('_', ' ', rtrim($table, 's'))));
    // Special cases for naming (optional)
    if ($table === 'admins') $className = 'Admin';
    if ($table === 'print_jobs') $className = 'PrintJob';
    if ($table === 'print_copies') $className = 'PrintCopy';
    if ($table === 'departments') $className = 'Department';

    $filePath = "$modelsDir/$className.php";

    echo "Syncing model for table '$table' -> $className.php\n";

    $content = "<?php\n\n";
    $content .= "namespace App\Models;\n\n";
    $content .= "class $className extends BaseModel {\n";
    $content .= "    protected \$table = '$table';\n\n";

    // Basic CRUD methods could be here, but they are in BaseModel.
    // We can add specific methods based on columns if needed.
    
    // Get columns to add helper methods or documentation
    $columnsStmt = $db->query("DESCRIBE `$table` ");
    $columns = $columnsStmt->fetchAll();

    $content .= "    /**\n";
    foreach ($columns as $column) {
        $content .= "     * @property {$column['Type']} {$column['Field']}\n";
    }
    $content .= "     */\n\n";

    // Add a simple create method template if it doesn't exist
    $fields = [];
    $placeholders = [];
    $dataArray = [];
    foreach ($columns as $column) {
        if ($column['Field'] !== 'id' && $column['Field'] !== 'created_at' && $column['Field'] !== 'updated_at') {
            $fields[] = $column['Field'];
            $placeholders[] = "?";
            if ($column['Field'] === 'password') {
                $dataArray[] = "password_hash(\${$column['Field']}, PASSWORD_BCRYPT)";
            } else {
                $dataArray[] = "\${$column['Field']}";
            }
        }
    }

    $fieldsStr = implode(', ', $fields);
    $placeholdersStr = implode(', ', $placeholders);
    $paramsStr = '$' . implode(', $', $fields);

    $content .= "    public function create($paramsStr) {\n";
    $content .= "        \$stmt = \$this->db->prepare(\"INSERT INTO {\$this->table} ($fieldsStr) VALUES ($placeholdersStr)\");\n";
    $content .= "        if (\$stmt->execute([" . implode(', ', $dataArray) . "])) {\n";
    $content .= "            return \$this->db->lastInsertId();\n";
    $content .= "        }\n";
    $content .= "        return false;\n";
    $content .= "    }\n";

    $content .= "}\n";

    file_put_contents($filePath, $content);
}

echo "Synchronization complete.\n";
