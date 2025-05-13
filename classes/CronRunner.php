<?php

namespace App\Cron;

class CronRunner
{
    private array $jobs = [];
    private string $logPath;

    public function __construct(string $logDir = __DIR__ . "/../logs/cron/")
    {
        $this->logPath = rtrim($logDir, "/") . "/";
        if (!is_dir($this->logPath)) {
            mkdir($this->logPath, 0777, true);
        }
    }

    /**
     * Register a new cron job
     */
    public function addJob(string $name, callable $callback): void
    {
        $this->jobs[$name] = $callback;
    }

    /**
     * Run all registered jobs
     */
    public function runAll(): void
    {
        foreach ($this->jobs as $name => $job) {
            $this->runSingle($name, $job);
        }
    }

    /**
     * Run a specific job by name
     */
    public function run(string $name): void
    {
        if (!isset($this->jobs[$name])) {
            $this->log("ERROR", $name, "Job not found.");
            return;
        }

        $this->runSingle($name, $this->jobs[$name]);
    }

    /**
     * Internal: Execute a job and handle logging
     */
    private function runSingle(string $name, callable $job): void
    {
        $start = microtime(true);
        try {
            call_user_func($job);
            $duration = round(microtime(true) - $start, 4);
            $this->log("SUCCESS", $name, "Executed in {$duration} sec");
        } catch (\Throwable $e) {
            $this->log("FAILURE", $name, $e->getMessage());
        }
    }

    /**
     * Log job execution status
     */
    private function log(string $status, string $name, string $message): void
    {
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $logFile = $this->logPath . "cron-{$date}.log";

        $line = "[{$time}] {$status} - {$name} => {$message}" . PHP_EOL;
        file_put_contents($logFile, $line, FILE_APPEND);
    }
}

