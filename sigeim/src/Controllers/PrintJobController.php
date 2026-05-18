<?php

namespace App\Controllers;

use App\Models\PrintJob;
use App\Models\PrintCopy;

class PrintJobController {
    public function queue() {
        $jobModel = new PrintJob();
        $copyModel = new PrintCopy();
        
        $jobs = $jobModel->getAllWithDepartment();
        
        // If logged in, we'll need copies for each job
        $isLoggedIn = isset($_COOKIE['remember_me']) && $_COOKIE['remember_me'] === 'true';
        
        if ($isLoggedIn) {
            foreach ($jobs as &$job) {
                $job['copies'] = $copyModel->getByJobId($job['id']);
            }
        }
        
        return [
            'jobs' => $jobs,
            'isLoggedIn' => $isLoggedIn
        ];
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }

        $isLoggedIn = isset($_COOKIE['remember_me']) && $_COOKIE['remember_me'] === 'true';
        if (!$isLoggedIn) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        $id = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$id || !$status) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing parameters']);
            exit;
        }

        $jobModel = new PrintJob();
        if ($jobModel->updateStatus($id, $status)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        exit;
    }
}
