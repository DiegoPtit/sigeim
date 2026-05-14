<?php

namespace App\Controllers;

use App\Models\PrintJob;
use App\Models\PrintCopy;
use App\Helpers\PrintStatus;
use Exception;

class UploadController {
    
    public function process() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /subida');
            exit;
        }

        try {
            // 1. Validaciones básicas y de error de subida
            if (!isset($_FILES['document'])) {
                throw new Exception("No se ha recibido ningún archivo.");
            }

            $fileError = $_FILES['document']['error'];
            if ($fileError !== UPLOAD_ERR_OK) {
                $errorMessages = [
                    UPLOAD_ERR_INI_SIZE   => "El archivo excede el tamaño máximo permitido por el servidor.",
                    UPLOAD_ERR_FORM_SIZE  => "El archivo excede el tamaño máximo permitido por el formulario.",
                    UPLOAD_ERR_PARTIAL    => "El archivo solo se subió parcialmente.",
                    UPLOAD_ERR_NO_FILE    => "No se subió ningún archivo.",
                    UPLOAD_ERR_NO_TMP_DIR => "Falta la carpeta temporal.",
                    UPLOAD_ERR_CANT_WRITE => "Error al escribir el archivo en el disco.",
                    UPLOAD_ERR_EXTENSION  => "Una extensión de PHP detuvo la subida."
                ];
                throw new Exception($errorMessages[$fileError] ?? "Error desconocido en la subida.");
            }

            // 2. Validación de extensiones permitidas
            $allowedExtensions = [
                'pdf', 
                'doc', 'docx', 
                'xls', 'xlsx', 
                'ppt', 'pptx',
                'jpg', 'jpeg', 'png', 'webp'
            ];
            
            $fileName = $_FILES['document']['name'];
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($fileType, $allowedExtensions)) {
                throw new Exception("Formato de archivo no permitido. Solo se aceptan: PDF, Word, Excel, PowerPoint e Imágenes.");
            }

            // 3. Preparar el trabajo de impresión
            $printJobModel = new PrintJob();
            $docName = $_POST['doc_name'] ?? 'Sin nombre';
            $deptId = $_POST['department'] ?? null;
            $notes = $_POST['notes'] ?? '';

            // Guardar archivo físico
            $uploadDir = __DIR__ . '/../../storage/uploads/';
            
            // Intentar crear el directorio si no existe
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    throw new Exception("No se pudo crear el directorio de subidas. Verifique los permisos en el servidor.");
                }
            }

            // Verificar si el directorio es escribible
            if (!is_writable($uploadDir)) {
                throw new Exception("El servidor no tiene permisos de escritura en la carpeta de subidas.");
            }
            
            $safeFileName = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $fileName);
            $targetFile = $uploadDir . $safeFileName;
            
            if (!move_uploaded_file($_FILES['document']['tmp_name'], $targetFile)) {
                throw new Exception("Error al mover el archivo al servidor.");
            }

            $totalCopies = intval($_POST['total_copies'] ?? 1);

            // Crear registro del trabajo con status inicial 'pendiente'
            $jobId = $printJobModel->create(
                $docName, 
                '/storage/uploads/' . $safeFileName, 
                $fileType, 
                $deptId, 
                PrintStatus::PENDING,
                $totalCopies
            );
            
            if (!$jobId) throw new Exception("Error al registrar el trabajo en la base de datos.");

            // 3. Guardar las copias/configuraciones
            $printCopyModel = new PrintCopy();
            
            if (isset($_POST['configs']) && is_array($_POST['configs'])) {
                foreach ($_POST['configs'] as $config) {
                    // Lógica de cantidad: Si es 'iguales', se toma el total. Si no, 1 por cada fila.
                    $qty = (count($_POST['configs']) === 1) ? $totalCopies : 1;
                    
                    $isDouble = isset($config['is_double']) ? 1 : 0;
                    $pages = isset($config['all_pages']) ? 'todas' : ($config['pages'] ?? 'todas');
                    
                    $printCopyModel->create(
                        $jobId, 
                        $qty, 
                        $config['papel'], 
                        $config['modo'], 
                        $config['orientacion'], 
                        $config['escala'], 
                        $isDouble,
                        $pages, 
                        $notes
                    );
                }
            }

            // 4. Retornar éxito
            return [
                'success' => true,
                'message_title' => '¡Documento Encolado!',
                'message_body' => 'Tu solicitud de impresión ha sido registrada exitosamente. El estado actual es: <b>' . PrintStatus::label(PrintStatus::PENDING) . '</b>.'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message_title' => 'Error en el proceso',
                'message_body' => $e->getMessage()
            ];
        }
    }
}
