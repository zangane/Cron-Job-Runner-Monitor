<?php

require_once __DIR__ . "/classes/CronRunner.php";

use App\Cron\CronRunner;

$cron = new CronRunner();

// Register a simple job: create a backup file
$cron->addJob("backup_file", function () {
    $backupFile = __DIR__ . "/backup_" . date("Ymd_His") . ".txt";
    file_put_contents($backupFile, "Backup created at " . date("Y-m-d H:i:s"));
});

// Register another job: simulate sending email
$cron->addJob("send_email", function () {
    // Simulate email sending
    if (rand(0, 1)) {
        // Simulate success
        echo "Email sent!" . PHP_EOL;
    } else {
        // Simulate failure
        throw new Exception("Failed to connect to SMTP server");
    }
});

// Execute all registered jobs
$cron->runAll();

