<?php

require_once __DIR__ . '/public/index.php';

use App\Services\Database;

$db = Database::getInstance();

$migrationsDir = __DIR__ . '/database/migrations';
$files = scandir($migrationsDir);

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
        echo "Running migration: $file\n";
        $sql = file_get_contents("$migrationsDir/$file");
        try {
            $db->exec($sql);
            echo "Success!\n";
        } catch (PDOException $e) {
            echo "Error running migration $file: " . $e->getMessage() . "\n";
        }
    }
}
