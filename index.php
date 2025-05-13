<?php

require_once __DIR__ . "/classes/CronRunner.php";

use App\Cron\CronRunner;

$cron = new CronRunner();

// Register some jobs
$cron->addJob("clear_temp", function () {
    $temp = __DIR__ . "/tmp.txt";
    file_put_contents($temp, "Temporary file created at " . date("Y-m-d H:i:s"));
});

$cron->addJob("log_heartbeat", function () {
    $heartbeat = __DIR__ . "/heartbeat.log";
    file_put_contents($heartbeat, "[" . date("H:i:s") . "] Heartbeat OK" . PHP_EOL, FILE_APPEND);
});

// Run all jobs
$cron->runAll();
