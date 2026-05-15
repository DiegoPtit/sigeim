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
}
